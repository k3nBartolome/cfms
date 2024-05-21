<?php

namespace App\Http\Controllers;

use App\Exports\DashboardClassesExportWeek;
use App\Exports\StaffingExport;
use App\Models\Classes;
use App\Models\DateRange;
use App\Models\Program;
use App\Models\Site;
use App\Models\SmartRecruitData;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CapEmailController extends Controller
{

    public function sendEmailStaffing(Request $request)
    {
        $weeklyPipe = $this->weeklyPipe();
        $wtd = $this->wtd();
        /*  $ytd = $this->ytd(); */

        $excelFileName = '00 PH Hiring Tracker_' . date('Y-m-d') . '.xlsx';

        $worksheetNames = [
            'Weekly Pipe',
            'MTD',
            /*  'YTD', */
        ];

        Excel::store(new StaffingExport(
            $weeklyPipe,
            $wtd,
            //$ytd,
            $worksheetNames,
        ), 'public/' . $excelFileName);

        $recipients = ['kryss.bartolome@vxi.com' /* , 'arielito.pascua@vxi.com', 'xaviera.barrantes@vxi.com', 'Philipino.Mercado@vxi.com', 'Aina.Dytioco@vxi.com', 'Ann.Gomez@vxi.com', 'Jemalyn.Fabiano@vxi.com', 'Kathryn.Olis@vxi.com'  */];
        $subject = 'PH Hiring Tracker - as of ' . date('F j, Y');
        $excelFilePath = public_path('storage/' . $excelFileName);

        Mail::send('staffing', [/* 'ytd' => $ytd, */'wtd' => $wtd, 'weeklyPipe' => $weeklyPipe], function ($message) use ($recipients, $subject, $excelFilePath, $excelFileName) {
            $message->from('TA.Insights@vxi.com', 'TA Reports');
            $message->to($recipients);
            $message->subject($subject);
            $message->attach($excelFilePath, [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        });

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function weeklyPipe()
    {

        $year = 2024;
        $date = Carbon::now()->format('Y-m-d');

        $dateRange = DB::table('date_ranges')
            ->select('week_start', 'week_end')
            ->where('week_start', '<=', $date)
            ->where('week_end', '>=', $date)
            ->where('year',  $year)
            ->first();
        if (!$dateRange) {
            return response()->json(['error' => 'No date range found for the current date.']);
        }

        $distinctDateRanges = DB::table('date_ranges')
            ->whereIn('week_end', [
                Carbon::parse($dateRange->week_end)->subWeek(),
                $dateRange->week_end,
                Carbon::parse($dateRange->week_end)->addWeek(),
                Carbon::parse($dateRange->week_end)->addWeeks(2),

            ])
            ->pluck('date_id');

        $weeklyTotals = [];
        $weeklyData = [];

        foreach ($distinctDateRanges as $dateRangeId) {
            $staffing = DB::table('class_staffing')
                ->leftJoin('classes', 'class_staffing.classes_id', '=', 'classes.id')
                ->leftJoin('date_ranges', 'classes.date_range_id', '=', 'date_ranges.id')
                ->leftJoin('sites', 'classes.site_id', '=', 'sites.id')
                ->leftJoin('programs', function ($join) {
                    $join->on('classes.program_id', '=', 'programs.id')
                        ->on('sites.id', '=', 'programs.site_id');
                })
                ->select(
                    'class_staffing.*',
                    'classes.*',
                    'sites.*',
                    'programs.*',
                    'date_ranges.*',
                    DB::raw('COALESCE(classes.total_target, 0) as total'),
                    DB::raw('COALESCE(date_ranges.date_id, 0) as date_range_id'),
                    DB::raw('COALESCE(date_ranges.date_range, null) as week_name'),
                    DB::raw('COALESCE(sites.site_id, 0) as site_id'),
                    DB::raw('COALESCE(programs.program_id, 0) as program_id'),
                    DB::raw('COALESCE(sites.name, null) as site_name'),
                    DB::raw('COALESCE(programs.name, null) as program_name'),
                    DB::raw('COALESCE(programs.program_group, null) as program_group')
                )
                ->where('class_staffing.active_status', 1)
                ->where('classes.total_target', '>', 0)
                ->where('sites.country', 'Philippines')
                ->where('date_ranges.date_id', $dateRangeId)
                ->get();

            foreach ($staffing as $item) {
                $siteId = $item->site_id;
                $programId = $item->program_id;
                $weekName = $item->week_name;

                $key = $dateRangeId . '' . $siteId . '' . $programId;

                if (!isset($weeklyData[$weekName])) {
                    $weeklyData[$weekName] = [];
                }

                if (!isset($weeklyData[$weekName][$key])) {
                    $weeklyData[$weekName][$key] = [
                        'week_name' => $item->week_name,
                        'site_name' => $item->site_name,
                        'program_name' => $item->program_name,
                        'program_group' => $item->program_group,
                        'total_target' => 0,
                        'show_ups_internal' => 0,
                        'show_ups_external' => 0,
                        'show_ups_total' => 0,
                        'fillrate' => 0,
                        'pending_jo' => 0,
                        'pending_berlitz' => 0,
                        'pending_ov' => 0,
                        'day_1' => 0,
                        'day_1sup' => 0,
                        'pipeline_total' => 0,
                        'hires_goal' => 0,
                        'color_status' => '',
                    ];
                }
                $weeklyData[$weekName][$key]['pending_ov'] += $item->pending_ov;
                $weeklyData[$weekName][$key]['pending_jo'] += $item->pending_jo;
                $weeklyData[$weekName][$key]['pending_berlitz'] += $item->pending_berlitz;
                $weeklyData[$weekName][$key]['total_target'] += $item->total_target;
                $weeklyData[$weekName][$key]['show_ups_internal'] += $item->show_ups_internal;
                $weeklyData[$weekName][$key]['show_ups_external'] += $item->show_ups_external;
                $weeklyData[$weekName][$key]['show_ups_total'] += $item->show_ups_total;
                $weeklyData[$weekName][$key]['day_1'] += $item->day_1;
                $weeklyData[$weekName][$key]['pipeline_total'] += $item->pipeline_total;
                $weeklyData[$weekName][$key]['hires_goal'] = $item->total_target != 0 ? number_format(($item->pipeline_total / $item->total_target) * 100, 1) : 0;
                $weeklyData[$weekName][$key]['fillrate'] = $item->total_target != 0 ? number_format(($item->show_ups_total / $item->total_target) * 100, 1) : 0;
                $weeklyData[$weekName][$key]['day_1sup'] = $item->total_target != 0 ? number_format(($item->day_1 / $item->total_target) * 100, 1) : 0;

                if ($distinctDateRanges[0] == $dateRangeId) {
                    $weeklyData[$weekName][$key]['color_status'] = ($weeklyData[$weekName][$key]['fillrate'] >= 100) ? 'Green' : 'Red';
                } elseif ($distinctDateRanges[1] == $dateRangeId) {
                    $weeklyData[$weekName][$key]['color_status'] = ($weeklyData[$weekName][$key]['hires_goal'] >= 100) ? 'Green' : 'Red';
                }
                elseif ($distinctDateRanges[2] == $dateRangeId) {
                    $weeklyData[$weekName][$key]['color_status'] = ($weeklyData[$weekName][$key]['hires_goal'] >= 100) ? 'Green' : 'Red';
                }
                 elseif ($distinctDateRanges[3] == $dateRangeId) {
                    if ($weeklyData[$weekName][$key]['hires_goal'] >= 100) {
                        $weeklyData[$weekName][$key]['color_status'] = 'Green';
                    } elseif ($weeklyData[$weekName][$key]['hires_goal'] >= 50) {
                        $weeklyData[$weekName][$key]['color_status'] = 'Yellow';
                    } else {
                        $weeklyData[$weekName][$key]['color_status'] = 'Red';
                    }
                }

                if (!isset($weeklyTotals[$weekName])) {
                    $weeklyTotals[$weekName] = [
                        'total_target' => 0,
                        'show_ups_internal' => 0,
                        'show_ups_external' => 0,
                        'show_ups_total' => 0,
                        'day_1' => 0,
                        'pipeline_total' => 0,
                        'pending_jo' => 0,
            'pending_berlitz' => 0,
            'pending_ov' => 0,
                    ];
                }
                $weeklyTotals[$weekName]['total_target'] += $item->total_target;
                $weeklyTotals[$weekName]['show_ups_internal'] += $item->show_ups_internal;
                $weeklyTotals[$weekName]['show_ups_external'] += $item->show_ups_external;
                $weeklyTotals[$weekName]['show_ups_total'] += $item->show_ups_total;
                $weeklyTotals[$weekName]['day_1'] += $item->day_1;
                $weeklyTotals[$weekName]['pipeline_total'] += $item->pipeline_total;
                $weeklyTotals[$weekName]['pending_jo'] += $item->pending_jo;
                $weeklyTotals[$weekName]['pending_berlitz'] += $item->pending_berlitz;
                $weeklyTotals[$weekName]['pending_ov'] += $item->pending_ov;
            }
        }

        // Prepare the weekly pipe data with weekly totals
        $weeklyPipeWithTotals = [];

        foreach ($weeklyData as $weekName => $weekItems) {
            // Add the weekly total for this week
            $weeklyPipeWithTotals["Weekly Total $weekName"] = [
                'week_name' => "Weekly Total for $weekName",
                'site_name' => '',
                'program_name' => '',
                'program_group' => '',
                'total_target' => $weeklyTotals[$weekName]['total_target'],
                'show_ups_internal' => $weeklyTotals[$weekName]['show_ups_internal'],
                'show_ups_external' => $weeklyTotals[$weekName]['show_ups_external'],
                'show_ups_total' => $weeklyTotals[$weekName]['show_ups_total'],
                'fillrate' => $weeklyTotals[$weekName]['total_target'] != 0 ? number_format(($weeklyTotals[$weekName]['show_ups_total'] / $weeklyTotals[$weekName]['total_target']) * 100, 1) : 0,
                'pending_jo' => $weeklyTotals[$weekName]['pending_jo'],
                'pending_berlitz' => $weeklyTotals[$weekName]['pending_berlitz'],
                'pending_ov' => $weeklyTotals[$weekName]['pending_ov'],
                'day_1' => $weeklyTotals[$weekName]['day_1'],
                'day_1sup' => $weeklyTotals[$weekName]['total_target'] != 0 ? number_format(($weeklyTotals[$weekName]['day_1'] / $weeklyTotals[$weekName]['total_target']) * 100, 1) : 0,
                'pipeline_total' => $weeklyTotals[$weekName]['pipeline_total'],
                'hires_goal' => $weeklyTotals[$weekName]['total_target'] != 0 ? number_format(($weeklyTotals[$weekName]['pipeline_total'] / $weeklyTotals[$weekName]['total_target']) * 100, 1) : 0,
                'color_status' => '',
            ];

            // Add the week's data
            $weeklyPipeWithTotals = array_merge($weeklyPipeWithTotals, $weekItems);
        }

        // Calculate the grand totals
        $grandTotals = [
            'total_target' => 0,
            'show_ups_internal' => 0,
            'show_ups_external' => 0,
            'show_ups_total' => 0,
            'fillrate' => 0,
            'day_1' => 0,
            'day_1sup' => 0,
            'pipeline_total' => 0,
            'hires_goal' => 0,
            'pending_jo' => 0,
            'pending_berlitz' => 0,
            'pending_ov' => 0,
        ];

        $totalCount = 0;
        $totalFillrate = 0;
        $totalDay1sup = 0;
        $totalHiresGoal = 0;

        foreach ($weeklyPipeWithTotals as $key => $sum) {
            if (strpos($sum['week_name'], 'Weekly Total') !== false) {
                continue;
            }

            $totalCount++;

            $grandTotals['total_target'] += $sum['total_target'];
            $grandTotals['show_ups_internal'] += $sum['show_ups_internal'];
            $grandTotals['show_ups_external'] += $sum['show_ups_external'];
            $grandTotals['show_ups_total'] += $sum['show_ups_total'];
            $grandTotals['pipeline_total'] += $sum['pipeline_total'];
            $grandTotals['day_1'] += $sum['day_1'];
            $grandTotals['pending_jo'] += $sum['pending_jo'];
            $grandTotals['pending_berlitz'] += $sum['pending_berlitz'];
            $grandTotals['pending_ov'] += $sum['pending_ov'];

            // Sum up for average calculation
            $totalFillrate += $sum['fillrate'];
            $totalDay1sup += $sum['day_1sup'];
            $totalHiresGoal += $sum['hires_goal'];
        }

        // Calculate averages
        $grandTotals['fillrate'] = $totalCount != 0 ? number_format($totalFillrate / $totalCount, 1) : 0;
        $grandTotals['day_1sup'] = $totalCount != 0 ? number_format($totalDay1sup / $totalCount, 1) : 0;
        $grandTotals['hires_goal'] = $totalCount != 0 ? number_format($totalHiresGoal / $totalCount, 1) : 0;

        // Mapped Grand Total
        $mappedGrandTotal = [
            'week_name' => 'Grand Total',
            'site_name' => '',
            'program_name' => '',
            'program_group' => '',
            'total_target' => $grandTotals['total_target'],
            'show_ups_internal' => $grandTotals['show_ups_internal'],
            'show_ups_external' => $grandTotals['show_ups_external'],
            'show_ups_total' => $grandTotals['show_ups_total'],
            'fillrate' => $grandTotals['fillrate'],
            'pending_jo' => $grandTotals['pending_jo'],
            'pending_berlitz' => $grandTotals['pending_berlitz'],
            'pending_ov' => $grandTotals['pending_ov'],
            'day_1' => $grandTotals['day_1'],
            'day_1sup' => $grandTotals['day_1sup'],
            'pipeline_total' => $grandTotals['pipeline_total'],
            'hires_goal' => $grandTotals['hires_goal'],
            'color_status' => '',
        ];

        // Merge Grand Total and Weekly Pipe Data with Totals
        $weeklyPipe = array_merge(['Grand Total' => $mappedGrandTotal], $weeklyPipeWithTotals);
        return $weeklyPipe;
    }
    public function wtd()
    {
        $year = 2024;
        $date = Carbon::now()->format('Y-m-d');
        $month = null;

        $dateRange = DB::table('date_ranges')
            ->select('month', 'month_num')
            ->where('week_start', '<=', $date)
            ->where('week_end', '>=', $date)
            ->first();

        if ($dateRange) {
            $month = $dateRange->month_num;
        }

        $distinctMonthsAndWeeks = DB::table('date_ranges')
            ->select([
                'month_num',
                DB::raw('COALESCE(date_ranges.month, null) as month_name'),
                'week_start',
                'week_end', 'date_range',
            ])
            ->where('year', $year)
            ->where('month_num', $month)
            ->distinct()
            ->get();

        $wtd = [];
        $grandTotals = [
            'total_target' => 0,
            'pipeline_total' => 0,
            'pipeline_goal' => 0,
            'total_internal' => 0,
            'total_external' => 0,
            'jo' => 0,
            'versant' => 0,
            'ov' => 0,
            'internal' => 0,
            'external' => 0,
            'total_show_ups' => 0,
            'fill_rate' => 0,
            'day_1' => 0,
            'day_1sup' => 0,
        ];

        foreach ($distinctMonthsAndWeeks as $item) {
            $monthName = $item->month_name;
            $weekStart = $item->week_start;
            $weekEnd = $item->week_end;
            $weekName = $item->date_range;

            $staffing = DB::table('class_staffing')
                ->leftJoin('classes', 'class_staffing.classes_id', '=', 'classes.id')
                ->leftJoin('date_ranges', 'classes.date_range_id', '=', 'date_ranges.id')
                ->leftJoin('sites', 'classes.site_id', '=', 'sites.id')
                ->leftJoin('programs', 'classes.program_id', '=', 'programs.id')
                ->select(
                    'class_staffing.*',
                    'classes.*',
                    'sites.*',
                    'programs.*',
                    'date_ranges.*',
                    DB::raw('COALESCE(date_ranges.date_id, 0) as date_range_id'),
                    DB::raw('COALESCE(date_ranges.month_num, 0) as month_num'),
                    DB::raw('COALESCE(date_ranges.month, null) as month_name'),
                    DB::raw('COALESCE(date_ranges.date_range, null) as week_name'),
                    DB::raw('COALESCE(date_ranges.week_start, null) as week_start'),
                    DB::raw('COALESCE(date_ranges.week_end, null) as week_end'),
                    DB::raw('COALESCE(sites.site_id, 0) as site_id'),
                    DB::raw('COALESCE(programs.program_id, 0) as program_id'),
                    DB::raw('COALESCE(sites.name, null) as site_name'),
                    DB::raw('COALESCE(programs.name, null) as program_name')
                )
                ->where('class_staffing.active_status', 1)
                ->where('date_ranges.month_num', $item->month_num)
                ->where('date_ranges.year', $year)
                ->where('date_ranges.week_start', $weekStart)
                ->where('date_ranges.week_end', $weekEnd)
                ->get();

            $wtd[] = [
                'month' => $monthName,
                'week_name' => $weekName,
                'total_target' => $staffing->sum('total_target'),
                'pipeline_total' => $staffing->sum('pipeline_total'),
                'pipeline_goal' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('pipeline_total') / $staffing->sum('total_target')) * 100, 1) : 0,
                'total_internal' => $staffing->sum('internals_hires'),
                'total_external' => $staffing->sum('with_jo'),
                'jo' => $staffing->sum('pending_jo'),
                'versant' => $staffing->sum('pending_berlitz'),
                'ov' => $staffing->sum('pending_ov'),
                'internal' => $staffing->sum('internal'),
                'external' => $staffing->sum('show_ups_external'),
                'total_show_ups' => $staffing->sum('show_ups_total'),
                'fill_rate' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('show_ups_total') / $staffing->sum('total_target')) * 100, 1) : 0,
                'day_1' => $staffing->sum('day_1'),
                'day_1sup' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('day_1') / $staffing->sum('total_target')) * 100, 1) : 0,
            ];

            foreach ($grandTotals as $key => $value) {
                if ($key !== 'fillrate') {
                    $grandTotals[$key] += $wtd[count($wtd) - 1][$key];
                }
            }
        }

        // Calculate fill rate, day 1 supervision rate, and hires goal
        $fillRateGrandTotal = $grandTotals['total_target'] != 0 ?
        number_format(($grandTotals['total_show_ups'] / $grandTotals['total_target']) * 100, 1) : 0;
        $day1SupGrandTotal = $grandTotals['total_target'] != 0 ?
        number_format(($grandTotals['day_1'] / $grandTotals['total_target']) * 100, 1) : 0;
        $hiresGoalGrandTotal = $grandTotals['total_target'] != 0 ?
        number_format(($grandTotals['pipeline_total'] / $grandTotals['total_target']) * 100, 1) : 0;
        $grandTotalRow = [
            'month' => 'Grand Total',
            'week_name' => '',
            'total_target' => $grandTotals['total_target'],
            'pipeline_total' => $grandTotals['pipeline_total'],
            'pipeline_goal' => $grandTotals['pipeline_goal'],
            'total_internal' => $grandTotals['total_internal'],
            'total_external' => $grandTotals['total_external'],
            'jo' => $grandTotals['jo'],
            'versant' => $grandTotals['versant'],
            'ov' => $grandTotals['ov'],
            'internal' => $grandTotals['internal'],
            'external' => $grandTotals['external'],
            'total_show_ups' => $grandTotals['total_show_ups'],
            'fill_rate' => $fillRateGrandTotal,
            'day_1' => $grandTotals['day_1'],
            'day_1sup' => $day1SupGrandTotal,
        ];

        $wtd[] = $grandTotalRow;

        return $wtd;
    }

    public function ytd()
    {
        $distinctMonths = DB::table('date_ranges')
            ->select([
                'month_num',
                DB::raw('COALESCE(date_ranges.month, null) as month_name'),
            ])
            ->distinct()
            ->get();
        $ytd = [];
        $grandTotals = [
            'total_target' => 0,
            'internal' => 0,
            'external' => 0,
            'total' => 0,
            'fillrate' => 0,
            'day_1' => 0,
            'day_1sup' => 0,
            'pipeline_total' => 0,
            'hires_goal' => 0,
        ];
        $totalShowUpsTotalAllMonths = 0;
        $totalTargetsAllMonths = 0;
        $totalDay1AllMonths = 0;
        $totalPipelineTotalAllMonths = 0;
        $totalInternalAllMonths = 0;
        $totalExternalAllMonths = 0;
        foreach ($distinctMonths as $monthData) {
            $monthNum = $monthData->month_num;
            $monthName = $monthData->month_name;
            $year = 2024;
            $staffing = DB::table('class_staffing')
                ->leftJoin('classes', 'class_staffing.classes_id', '=', 'classes.id')
                ->leftJoin('date_ranges', 'classes.date_range_id', '=', 'date_ranges.id')
                ->leftJoin('sites', 'classes.site_id', '=', 'sites.id')
                ->leftJoin('programs', 'classes.program_id', '=', 'programs.id')
                ->select(
                    'class_staffing.*',
                    'classes.*',
                    'sites.*',
                    'programs.*',
                    'date_ranges.*',
                    DB::raw('COALESCE(date_ranges.date_id, 0) as date_range_id'),
                    DB::raw('COALESCE(date_ranges.month_num, 0) as month_num'),
                    DB::raw('COALESCE(date_ranges.month, null) as month_name'),
                    DB::raw('COALESCE(date_ranges.date_range, null) as week_name'),
                    DB::raw('COALESCE(sites.site_id, 0) as site_id'),
                    DB::raw('COALESCE(programs.program_id, 0) as program_id'),
                    DB::raw('COALESCE(sites.name, null) as site_name'),
                    DB::raw('COALESCE(programs.name, null) as program_name')
                )
                ->where('class_staffing.active_status', 1)
                ->where('classes.status', 'Active')
                ->where('date_ranges.month_num', $monthNum)
                ->where('date_ranges.year', $year)
                ->get();

            $totalShowUpsTotalAllMonths += $staffing->sum('show_ups_total');
            $totalTargetsAllMonths += $staffing->sum('total_target');
            $totalDay1AllMonths += $staffing->sum('day_1');
            $totalInternalAllMonths += $staffing->sum('show_ups_internal');
            $totalExternalAllMonths += $staffing->sum('show_ups_external');
            $totalPipelineTotalAllMonths += $staffing->sum('pipeline_total');
            $ytd[$monthName] = [
                'month' => $monthName,
                'total_target' => $staffing->sum('total_target'),
                'internal' => $staffing->sum('show_ups_internal'),
                'external' => $staffing->sum('show_ups_external'),
                'total' => $staffing->sum('show_ups_total'),
                'fillrate' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('show_ups_total') / $staffing->sum('total_target')) * 100, 2) : 0,
                'day_1' => $staffing->sum('day_1'),
                'day_1sup' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('day_1') / $staffing->sum('total_target')) * 100, 2) : 0,
                'pipeline_total' => $staffing->sum('pipeline_total'),
                'hires_goal' => $staffing->sum('total_target') != 0 ? number_format(($staffing->sum('pipeline_total') / $staffing->sum('total_target')) * 100, 2) : 0,
            ];
            foreach ($grandTotals as $key => $value) {
                if ($key !== 'fillrate') {
                    $grandTotals[$key] += $ytd[$monthName][$key];
                }
            }
        }

        // Calculate fill rate, day 1 supervision rate, and hires goal
        $fillRateGrandTotal = $totalTargetsAllMonths != 0 ?
        number_format(($totalShowUpsTotalAllMonths / $totalTargetsAllMonths) * 100, 2) : 0;
        $day1SupGrandTotal = $totalTargetsAllMonths != 0 ?
        number_format(($totalDay1AllMonths / $totalTargetsAllMonths) * 100, 2) : 0;
        $hiresGoalGrandTotal = $totalTargetsAllMonths != 0 ?
        number_format(($totalPipelineTotalAllMonths / $totalTargetsAllMonths) * 100, 2) : 0;

        // Create Grand Total row
        $grandTotalRow = [
            'month' => 'Grand Total',
            'total_target' => $totalTargetsAllMonths,
            'internal' => $totalInternalAllMonths, // Fill with your calculation if needed
            'external' => $totalExternalAllMonths, // Fill with your calculation if needed
            'total' => $totalShowUpsTotalAllMonths,
            'fillrate' => $fillRateGrandTotal,
            'day_1' => $totalDay1AllMonths,
            'day_1sup' => $day1SupGrandTotal,
            'pipeline_total' => $totalPipelineTotalAllMonths,
            'hires_goal' => $hiresGoalGrandTotal,
        ];

        // Merge Grand Total row with the rest of the data
        $ytd = array_merge([$grandTotalRow], $ytd);

        return $ytd;
    }

    //capfile
    public function sendEmail(Request $request)
    {
        $mappedGroupedClasses = $this->retrieveDataForEmail();
        $mappedExternalClasses = $this->retrieveExternalForEmail();
        $mappedInternalClasses = $this->retrieveInternalForEmail();
        $mappedClassesMoved = $this->classesMoved();
        $mappedClassesCancelled = $this->classesCancelled();
        $mappedClassesSla = $this->classesSla();
        $outOfSlaHeadCount = $this->OutOfSla();
        $cancelledHeadCount = $this->Cancelled();
        $outOfSlaHeadCountMonth = $this->OutOfSlaMonth();
        $cancelledHeadCountMonth = $this->CancelledMonth();
        $mappedGroupedClassesWeek = $this->retrieveDataForEmailWeek();
        $mappedClasses = $this->retrieveDataForClassesEmail();
        $mappedB2Classes = $this->retrieveB2DataForEmail();
        $excelFileName = 'capfile' . time() . '.xlsx';
        $worksheetNames = [
            'Hiring Summary',
            'Site Summary',
            'External Summary',
            'Internal Summary',
            'Moved Classes',
            'Cancelled Classes',
            'Out Of SLA',
            'YTD Per Site Out of SLA',
            'YTD Per Site Cancellation',
            'MTD Per Site Out of SLA',
            'MTD Per Site Cancellation',
        ];
        Excel::store(new DashboardClassesExportWeek(
            $mappedGroupedClassesWeek,
            $mappedGroupedClasses,
            $mappedExternalClasses,
            $mappedInternalClasses,
            $mappedClassesMoved,
            $mappedClassesCancelled,
            $mappedClassesSla,
            $outOfSlaHeadCount,
            $cancelledHeadCount,
            $outOfSlaHeadCountMonth,
            $cancelledHeadCountMonth,
            $worksheetNames,
        ), 'public/' . $excelFileName);
        $recipients = ['kryss.bartolome@vxi.com' /* , 'arielito.pascua@vxi.com', 'xaviera.barrantes@vxi.com', 'Philipino.Mercado@vxi.com', 'Aina.Dytioco@vxi.com', 'Ann.Gomez@vxi.com', 'Jemalyn.Fabiano@vxi.com', 'Kathryn.Olis@vxi.com', 'Jay.Juliano@vxi.com', 'Yen.Gelido-Alejandro@vxi.com', 'PH_Talent_Acquisition_Leaders@vxi.com', 'PH_Talent_Acquisition_Management_Team@vxi.com'*/];
        $subject = 'PH TA Capacity File - as of ' . date('F j, Y');
        $excelFilePath = public_path('storage/' . $excelFileName);
        Mail::send('email', ['mappedGroupedClasses' => $mappedGroupedClasses, 'mappedClasses' => $mappedClasses, 'mappedB2Classes' => $mappedB2Classes, 'mappedExternalClasses' => $mappedExternalClasses, 'mappedInternalClasses' => $mappedInternalClasses], function ($message) use ($recipients, $subject, $excelFilePath) {
            $message->from('TA.Insights@vxi.com', 'TA Reports');
            $message->to($recipients);
            $message->subject($subject);
            $message->attach($excelFilePath, [
                'as' => '2024 PH TA CAPACITY FILE.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        });
        return response()->json(['message' => 'Email sent successfully']);
    }
    public function OutOfSlaMonth()
    {
        $sites = Site::where('is_active', 1)->where('country', 'Philippines')->get();
        $year = 2024;
        $date = Carbon::now()->format('Y-m-d');
        $month = null;

        $dateRange = DB::table('date_ranges')
            ->select('month', 'month_num')
            ->where('week_start', '<=', $date)
            ->where('week_end', '>=', $date)
            ->first();

        if ($dateRange) {
            $month = $dateRange->month_num;
        }
        $grandTotalByProgram = [];
        $grandTotalByWeeks = []; // Initialize array to accumulate notice weeks
        $maxProgramBySite = [];

        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            if (!isset($grandTotalByWeeks[$siteName])) {
                $grandTotalByWeeks[$siteName] = 0; // Initialize notice weeks accumulator
            }
            $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                    $subquery->where('month_num', $month)->where('year', $year);
                })
                ->whereHas('program', function ($subquery) {
                    $subquery->where('is_active', 1);
                })
                ->where('site_id', $siteId)
                ->where('status', 'Active')
                ->where('within_sla', 'Outside SLA-New class added')
                ->get();
            $totalTarget = $classes->sum('total_target');
            $notice_weeks = $classes->avg('notice_weeks');
            $grandTotalByProgram[$siteName] += $totalTarget;
            $grandTotalByWeeks[$siteName] += $notice_weeks; // Accumulate notice weeks
            $maxTotalTarget = $classes->max('total_target');
            $classesWithMaxTarget = $classes->filter(function ($class) use ($maxTotalTarget) {
                return $class->total_target == $maxTotalTarget;
            });
            $maxProgramIds = $classesWithMaxTarget->pluck('program_id')->toArray();
            $maxProgramNames = Program::whereIn('id', $maxProgramIds)->pluck('program_group')->toArray();

            $maxProgramBySite[$siteId] = [
                'program_ids' => $maxProgramIds,
                'program_names' => $maxProgramNames,
            ];
        }
        $outOfSlaHeadCountMonth = [];
        $totalHC = 0;
        $totalNoticeWeeks = 0; // Initialize total notice weeks
        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            $notice_weeks_avg = $grandTotalByWeeks[$siteName]; // Use the accumulated notice weeks
            $totalHC += $grandTotalByProgram[$siteName]; // Accumulate total HC

            $maxPrograms = isset($maxProgramBySite[$siteId]) ? implode(', ', array_unique($maxProgramBySite[$siteId]['program_names'])) : '';

            $outOfSlaHeadCountMonth[] = [
                'Site' => $siteName,
                'HC' => $grandTotalByProgram[$siteName],
                'Notice Weeks' => number_format($notice_weeks_avg, 2), // Format to two decimal places
                'Drivers' => $maxPrograms,
            ];

            // Accumulate total notice weeks
            $totalNoticeWeeks += $notice_weeks_avg;
        }

        // Calculate total average notice weeks
        $totalAverageNoticeWeeks = $totalNoticeWeeks / count($sites);

        // Add totals to the result
        $outOfSlaHeadCountMonth[] = [
            'Site' => 'Total',
            'HC' => $totalHC,
            'Notice Weeks' => number_format($totalAverageNoticeWeeks, 2), // Format to two decimal places
            'Drivers' => [], // No need to include Drivers for the total row
        ];

        return $outOfSlaHeadCountMonth;
    }
    public function OutOfSla()
    {
        $sites = Site::where('is_active', 1)->where('country', 'Philippines')->get();
        $year = 2024;

        $grandTotalByProgram = [];
        $grandTotalByWeeks = []; // Initialize array to accumulate notice weeks
        $maxProgramBySite = [];

        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            if (!isset($grandTotalByWeeks[$siteName])) {
                $grandTotalByWeeks[$siteName] = 0; // Initialize notice weeks accumulator
            }
            $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                ->whereHas('dateRange', function ($subquery) use ($year) {
                    $subquery->where('year', $year);
                })
                ->whereHas('program', function ($subquery) {
                    $subquery->where('is_active', 1);
                })
                ->where('site_id', $siteId)
                ->where('status', 'Active')
                ->where('within_sla', 'Outside SLA-New class added')
                ->get();
            $totalTarget = $classes->sum('total_target');
            $notice_weeks = $classes->avg('notice_weeks');
            $grandTotalByProgram[$siteName] += $totalTarget;
            $grandTotalByWeeks[$siteName] += $notice_weeks; // Accumulate notice weeks
            $maxTotalTarget = $classes->max('total_target');
            $classesWithMaxTarget = $classes->filter(function ($class) use ($maxTotalTarget) {
                return $class->total_target == $maxTotalTarget;
            });
            $maxProgramIds = $classesWithMaxTarget->pluck('program_id')->toArray();
            $maxProgramNames = Program::whereIn('id', $maxProgramIds)->pluck('program_group')->toArray();

            $maxProgramBySite[$siteId] = [
                'program_ids' => $maxProgramIds,
                'program_names' => $maxProgramNames,
            ];
        }
        $outOfSlaHeadCount = [];
        $totalHC = 0;
        $totalNoticeWeeks = 0; // Initialize total notice weeks
        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            $notice_weeks_avg = $grandTotalByWeeks[$siteName]; // Use the accumulated notice weeks
            $totalHC += $grandTotalByProgram[$siteName]; // Accumulate total HC

            $maxPrograms = isset($maxProgramBySite[$siteId]) ? implode(', ', array_unique($maxProgramBySite[$siteId]['program_names'])) : '';

            $outOfSlaHeadCount[] = [
                'Site' => $siteName,
                'HC' => $grandTotalByProgram[$siteName],
                'Notice Weeks' => number_format($notice_weeks_avg, 2), // Format to two decimal places
                'Drivers' => $maxPrograms,
            ];

            // Accumulate total notice weeks
            $totalNoticeWeeks += $notice_weeks_avg;
        }

        // Calculate total average notice weeks
        $totalAverageNoticeWeeks = $totalNoticeWeeks / count($sites);

        // Add totals to the result
        $outOfSlaHeadCount[] = [
            'Site' => 'Total',
            'HC' => $totalHC,
            'Notice Weeks' => number_format($totalAverageNoticeWeeks, 2), // Format to two decimal places
            'Drivers' => [], // No need to include Drivers for the total row
        ];

        return $outOfSlaHeadCount;
    }
    public function CancelledMonth()
    {
        $sites = Site::where('is_active', 1)->where('country', 'Philippines')->get();
        $year = 2024;
        $date = Carbon::now()->format('Y-m-d');
        $month = null;

        $dateRange = DB::table('date_ranges')
            ->select('month', 'month_num')
            ->where('week_start', '<=', $date)
            ->where('week_end', '>=', $date)
            ->first();

        if ($dateRange) {
            $month = $dateRange->month_num;
        }

        $grandTotalByProgram = [];
        $grandTotalByWeeks = [];
        $grandTotalByPipeline = [];
        $maxProgramBySite = [];
        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            if (!isset($grandTotalByWeeks[$siteName])) {
                $grandTotalByWeeks[$siteName] = 0;
            }
            if (!isset($grandTotalByPipeline[$siteName])) {
                $grandTotalByPipeline[$siteName] = 0;
            }
            $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                    $subquery->where('month_num', $month)->where('year', $year);
                })
                ->whereHas('program', function ($subquery) {
                    $subquery->where('is_active', 1);
                })
                ->where('site_id', $siteId)
                ->where(function ($query) {
                    $query->where('status', 'Cancelled')
                        ->orWhere('within_sla', 'LIKE', '%Cancellation%');
                })
                ->get();
            $totalTarget = $classes->sum('total_target');
            $pipelineOffered = $classes->sum('pipeline_offered');
            $notice_weeks = $classes->avg('notice_weeks');
            $grandTotalByProgram[$siteName] += $totalTarget;
            $grandTotalByWeeks[$siteName] += $notice_weeks;
            $grandTotalByPipeline[$siteName] += $pipelineOffered;
            $maxTotalTarget = $classes->max('total_target');
            $classesWithMaxTarget = $classes->filter(function ($class) use ($maxTotalTarget) {
                return $class->total_target == $maxTotalTarget;
            });
            $maxProgramIds = $classesWithMaxTarget->pluck('program_id')->toArray();
            $maxProgramNames = Program::whereIn('id', $maxProgramIds)->pluck('program_group')->toArray();

            $maxProgramBySite[$siteId] = [
                'program_ids' => $maxProgramIds,
                'program_names' => $maxProgramNames,
            ];
        }
        $totalHC = 0;
        $totalPipelineOffered = 0;
        foreach ($sites as $site) {
            $siteId = $site->id;
            $totalHC += $grandTotalByProgram[$site->name];
            $totalPipelineOffered += $grandTotalByPipeline[$site->name];
        }
        $totalNoticeWeeks = 0;
        foreach ($grandTotalByWeeks as $notice_weeks) {
            $totalNoticeWeeks += $notice_weeks;
        }
        $totalNoticeWeeks /= count($sites);
        $cancelledHeadCountMonth = [];
        foreach ($sites as $site) {
            $siteId = $site->id;
            $maxPrograms = isset($maxProgramBySite[$siteId]) ? implode(', ', array_unique($maxProgramBySite[$siteId]['program_names'])) : '';
            $cancelledHeadCountMonth[] = [
                'Site' => $site->name,
                'HC' => $grandTotalByProgram[$site->name],
                'Pipeline Offered' => $grandTotalByPipeline[$site->name],
                'Notice Weeks' => number_format($grandTotalByWeeks[$site->name], 2),
                'Drivers' => $maxPrograms,
            ];
        }
        $cancelledHeadCountMonth[] = [
            'Site' => 'Total',
            'HC' => $totalHC,
            'Pipeline Offered' => $totalPipelineOffered,
            'Notice Weeks' => number_format($totalNoticeWeeks, 2),
            'Drivers' => [],
        ];
        return $cancelledHeadCountMonth;
    }

    public function Cancelled()
    {
        $sites = Site::where('is_active', 1)->where('country', 'Philippines')->get();
        $year = 2024;
        $grandTotalByProgram = [];
        $grandTotalByWeeks = []; // Initialize array to accumulate notice weeks
        $grandTotalByPipeline = []; // Initialize array to accumulate pipeline offered
        $maxProgramBySite = [];

        foreach ($sites as $site) {
            $siteName = $site->name;
            $siteId = $site->id;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            if (!isset($grandTotalByWeeks[$siteName])) {
                $grandTotalByWeeks[$siteName] = 0; // Initialize notice weeks accumulator
            }
            if (!isset($grandTotalByPipeline[$siteName])) {
                $grandTotalByPipeline[$siteName] = 0; // Initialize pipeline offered accumulator
            }
            $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                ->whereHas('dateRange', function ($subquery) use ($year) {
                    $subquery->where('year', $year);
                })
                ->whereHas('program', function ($subquery) {
                    $subquery->where('is_active', 1);
                })
                ->where('site_id', $siteId)
                ->where(function ($query) {
                    $query->where('status', 'Cancelled')
                        ->orWhere('within_sla', 'LIKE', '%Cancellation%');
                })
                ->get();
            $totalTarget = $classes->sum('total_target');
            $pipelineOffered = $classes->sum('pipeline_offered'); // Compute pipeline offered
            $notice_weeks = $classes->avg('notice_weeks');
            $grandTotalByProgram[$siteName] += $totalTarget;
            $grandTotalByWeeks[$siteName] += $notice_weeks; // Accumulate notice weeks
            $grandTotalByPipeline[$siteName] += $pipelineOffered; // Accumulate pipeline offered
            $maxTotalTarget = $classes->max('total_target');
            $classesWithMaxTarget = $classes->filter(function ($class) use ($maxTotalTarget) {
                return $class->total_target == $maxTotalTarget;
            });
            $maxProgramIds = $classesWithMaxTarget->pluck('program_id')->toArray();
            $maxProgramNames = Program::whereIn('id', $maxProgramIds)->pluck('program_group')->toArray();

            $maxProgramBySite[$siteId] = [
                'program_ids' => $maxProgramIds,
                'program_names' => $maxProgramNames,
            ];
        }

        // Calculate total HC and total pipeline offered
        $totalHC = 0;
        $totalPipelineOffered = 0;
        foreach ($sites as $site) {
            $siteId = $site->id;
            $totalHC += $grandTotalByProgram[$site->name];
            $totalPipelineOffered += $grandTotalByPipeline[$site->name];
        }

        // Calculate total average notice weeks
        $totalNoticeWeeks = 0;
        foreach ($grandTotalByWeeks as $notice_weeks) {
            $totalNoticeWeeks += $notice_weeks;
        }
        $totalNoticeWeeks /= count($sites); // Calculate average notice weeks

        $cancelledHeadCount = [];
        foreach ($sites as $site) {
            $siteId = $site->id;
            $maxPrograms = isset($maxProgramBySite[$siteId]) ? implode(', ', array_unique($maxProgramBySite[$siteId]['program_names'])) : '';
            $cancelledHeadCount[] = [
                'Site' => $site->name,
                'HC' => $grandTotalByProgram[$site->name],
                'Pipeline Offered' => $grandTotalByPipeline[$site->name],
                'Notice Weeks' => number_format($grandTotalByWeeks[$site->name], 2),
                'Drivers' => $maxPrograms,
            ];
        }

        // Add totals to the result
        $cancelledHeadCount[] = [
            'Site' => 'Total',
            'HC' => $totalHC,
            'Pipeline Offered' => $totalPipelineOffered,
            'Notice Weeks' => number_format($totalNoticeWeeks, 2),
            'Drivers' => [],
        ];

        return $cancelledHeadCount;
    }

    public function classesMoved()
    {
        $classes = Classes::whereHas('site', function ($query) {
            $query->where('country', '=', 'Philippines');
        })
            ->whereHas('dateRange', function ($query) {
                $query->where('year', '=', '2024');
            })
            ->with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
            ->where('status', 'Moved')
            ->where('changes', '!=', 'Add Class')
            ->get();

        $formattedClasses = $classes->map(function ($class) {
            return [
                'id' => $class->id,
                'country' => $class->site->country,
                'region' => $class->site->region,
                'site_name' => $class->site->name,
                'program_name' => $class->program->name,
                'date_range' => $class->dateRange->date_range,
                'month' => $class->dateRange->month,
                'external_target' => $class->external_target,
                'internal_target' => $class->internal_target,
                'total_target' => $class->total_target,
                'within_sla' => $class->within_sla,
                'condition' => $class->condition,
                'original_start_date' => $class->original_start_date,
                'changes' => $class->changes,
                'agreed_start_date' => $class->agreed_start_date,
                'wfm_date_requested' => $class->wfm_date_requested,
                'notice_weeks' => number_format($class->notice_weeks, 2),
                'notice_days' => $class->notice_days,
                'pipeline_utilized' => $class->pipeline_utilized,
                'remarks' => $class->remarks,
                'status' => $class->status,
                'category' => $class->category,
                'type_of_hiring' => $class->type_of_hiring,
                'with_erf' => $class->with_erf,
                'erf_number' => $class->erf_number,
                'wave_no' => $class->wave_no,
                'ta' => $class->ta,
                'wf' => $class->wf,
                'tr' => $class->tr,
                'cl' => $class->cl,
                'op' => $class->op,
                'approved_by' => $class->approved_by,
                'cancelled_by' => $class->cancelled_by,
                'requested_by' => $class->requested_by,
                'created_by' => $class->createdByUser->name,
                'updated_by' => $class->updatedByUser ? $class->updatedByUser->name : null,
                'approved_date' => $class->approved_date,
                'cancelled_date' => $class->cancelled_date,
                'created_at' => $class->created_at->format('m-d-Y H:i'),
                'updated_at' => $class->updated_at->format('m-d-Y H:i'),
            ];
        });

        return $formattedClasses;
    }
    public function classesSla()
    {
        $classes = Classes::whereHas('site', function ($query) {
            $query->where('country', '=', 'Philippines');
        })
            ->whereHas('dateRange', function ($query) {
                $query->where('year', '=', '2024');
            })
            ->with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
            ->where('within_sla', 'Outside SLA-New class added')
            ->get();

        $formattedClasses = $classes->map(function ($class) {
            return [
                'id' => $class->id,
                'country' => $class->site->country,
                'region' => $class->site->region,
                'site_name' => $class->site->name,
                'program_name' => $class->program->name,
                'date_range' => $class->dateRange->date_range,
                'month' => $class->dateRange->month,
                'external_target' => $class->external_target,
                'internal_target' => $class->internal_target,
                'total_target' => $class->total_target,
                'within_sla' => $class->within_sla,
                'condition' => $class->condition,
                'original_start_date' => $class->original_start_date,
                'changes' => $class->changes,
                'agreed_start_date' => $class->agreed_start_date,
                'wfm_date_requested' => $class->wfm_date_requested,
                'notice_weeks' => number_format($class->notice_weeks, 2),
                'notice_days' => $class->notice_days,
                'pipeline_utilized' => $class->pipeline_utilized,
                'remarks' => $class->remarks,
                'status' => $class->status,
                'category' => $class->category,
                'type_of_hiring' => $class->type_of_hiring,
                'with_erf' => $class->with_erf,
                'erf_number' => $class->erf_number,
                'wave_no' => $class->wave_no,
                'ta' => $class->ta,
                'wf' => $class->wf,
                'tr' => $class->tr,
                'cl' => $class->cl,
                'op' => $class->op,
                'approved_by' => $class->approved_by,
                'cancelled_by' => $class->cancelled_by,
                'requested_by' => $class->requested_by,
                'created_by' => $class->createdByUser->name,
                'updated_by' => $class->updatedByUser ? $class->updatedByUser->name : null,
                'approved_date' => $class->approved_date,
                'cancelled_date' => $class->cancelled_date,
                'created_at' => $class->created_at->format('m-d-Y H:i'),
                'updated_at' => $class->updated_at->format('m-d-Y H:i'),
            ];
        });

        return $formattedClasses;
    }
    public function classesCancelled()
    {
        $classes = Classes::whereHas('site', function ($query) {
            $query->where('country', '=', 'Philippines');
        })
            ->whereHas('dateRange', function ($query) {
                $query->where('year', '=', '2024');
            })
            ->with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
            ->where(function ($query) {
                $query->where('status', 'Cancelled')
                    ->orWhere('within_sla', 'LIKE', '%Cancellation%');
            })
            ->get();

        $formattedClasses = $classes->map(function ($class) {
            return [
                'id' => $class->id,
                'country' => $class->site->country,
                'region' => $class->site->region,
                'site_name' => $class->site->name,
                'program_name' => $class->program->name,
                'date_range' => $class->dateRange->date_range,
                'month' => $class->dateRange->month,
                'external_target' => $class->external_target,
                'internal_target' => $class->internal_target,
                'total_target' => $class->total_target,
                'within_sla' => $class->within_sla,
                'condition' => $class->condition,
                'original_start_date' => $class->original_start_date,
                'changes' => $class->changes,
                'agreed_start_date' => $class->agreed_start_date,
                'wfm_date_requested' => $class->wfm_date_requested,
                'notice_weeks' => number_format($class->notice_weeks, 2),
                'notice_days' => $class->notice_days,
                'pipeline_utilized' => $class->pipeline_utilized,
                'remarks' => $class->remarks,
                'status' => $class->status,
                'category' => $class->category,
                'type_of_hiring' => $class->type_of_hiring,
                'with_erf' => $class->with_erf,
                'erf_number' => $class->erf_number,
                'wave_no' => $class->wave_no,
                'ta' => $class->ta,
                'wf' => $class->wf,
                'tr' => $class->tr,
                'cl' => $class->cl,
                'op' => $class->op,
                'approved_by' => $class->approved_by,
                'cancelled_by' => $class->cancelled_by,
                'requested_by' => $class->requested_by,
                'created_by' => $class->createdByUser->name,
                'updated_by' => $class->updatedByUser ? $class->updatedByUser->name : null,
                'approved_date' => $class->approved_date,
                'cancelled_date' => $class->cancelled_date,
                'created_at' => $class->created_at->format('m-d-Y H:i'),
                'updated_at' => $class->updated_at->format('m-d-Y H:i'),
            ];
        });

        return $formattedClasses;
    }
    public function retrieveDataForEmailWeek()
    {
        $programs = Program::with('site')

            ->when(true, function ($query) {
                $query->whereHas('site', function ($subquery) {
                    $subquery->where('is_active', 1);
                });

                $query->whereHas('site', function ($subquery) {
                    $subquery->where('country', 'Philippines');
                });
            })

            ->where('is_active', 1) // You can keep or remove this line based on your requirements
            ->get();

        $year = 2024;
        $dateRanges = DateRange::where('year', $year)
            ->get();

        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByMonth = [];
        $grandTotalByProgram = [];

        foreach ($programs as $program) {
            $siteName = $program->site->name;
            $programName = $program->name;

            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = [];
            }
            $grandTotalByProgram[$siteName][$programName] = 0;

            foreach ($dateRanges as $dateRange) {
                $programId = $program->id;
                $week = $dateRange->id;
                $month = $dateRange->month;

                $classes = Classes::where('site_id', $program->site_id)
                    ->where('program_id', $programId)
                    ->where('date_range_id', $dateRange->id)
                    ->where('status', 'Active')
                    ->get();

                $totalTarget = $classes->sum('total_target');

                if (!isset($grandTotalByWeek[$week])) {
                    $grandTotalByWeek[$week] = 0;
                }
                if (!isset($grandTotalByMonth[$month])) {
                    $grandTotalByMonth[$month] = 0;
                }

                $grandTotalByWeek[$week] += $totalTarget;
                $grandTotalByMonth[$month] += $totalTarget;

                $grandTotalByProgram[$siteName][$programName] += $totalTarget;

                if (!isset($groupedClasses[$siteName][$programName][$week])) {
                    $groupedClasses[$siteName][$programName][$week] = [
                        'total_target' => 0,
                    ];
                }
                if (!isset($groupedClasses[$siteName][$programName][$month])) {
                    $groupedClasses[$siteName][$programName][$month] = [
                        'total_target' => 0,
                    ];
                }

                $groupedClasses[$siteName][$programName][$week]['total_target'] += $totalTarget;
            }
        }

        $mappedGroupedClasses = [];

        foreach ($groupedClasses as $siteName => $siteData) {
            foreach ($siteData as $programName => $programData) {
                $weeklyData = [
                    '53' => 0,
                    '54' => 0,
                    '55' => 0,
                    '56' => 0,
                    '57' => 0,
                    '58' => 0,
                    '59' => 0,
                    '60' => 0,
                    '61' => 0,
                    '62' => 0,
                    '63' => 0,
                    '64' => 0,
                    '65' => 0,
                    '66' => 0,
                    '67' => 0,
                    '68' => 0,
                    '69' => 0,
                    '70' => 0,
                    '71' => 0,
                    '72' => 0,
                    '73' => 0,
                    '74' => 0,
                    '75' => 0,
                    '76' => 0,
                    '77' => 0,
                    '78' => 0,
                    '79' => 0,
                    '80' => 0,
                    '81' => 0,
                    '82' => 0,
                    '83' => 0,
                    '84' => 0,
                    '85' => 0,
                    '86' => 0,
                    '87' => 0,
                    '88' => 0,
                    '89' => 0,
                    '90' => 0,
                    '91' => 0,
                    '92' => 0,
                    '93' => 0,
                    '94' => 0,
                    '95' => 0,
                    '96' => 0,
                    '97' => 0,
                    '98' => 0,
                    '99' => 0,
                    '100' => 0,
                    '101' => 0,
                    '102' => 0,
                    '103' => 0,
                    '104' => 0,
                ];

                foreach ($programData as $week => $weekData) {
                    $weeklyData[$week] = isset($weekData['total_target']) ? $weekData['total_target'] : 0;
                }
                $grandTotal = $grandTotalByProgram[$siteName][$programName];
                if ($grandTotal != 0) {
                    $mappedGroupedClasses[] = [
                        'Site' => $siteName,
                        'Program' => $programName,
                        'Week1' => $weeklyData['53'] != 0 ? $weeklyData['53'] : '',

                        'Week2' => $weeklyData['54'] != 0 ? $weeklyData['54'] : '',
                        'Week3' => $weeklyData['55'] != 0 ? $weeklyData['55'] : '',
                        'Week4' => $weeklyData['56'] != 0 ? $weeklyData['56'] : '',
                        'Jan' => collect($weeklyData)->only([53, 54, 55, 56])->sum() != 0 ? collect($weeklyData)->only([53, 54, 55, 56])->sum() : '',
                        'Week5' => $weeklyData['57'] != 0 ? $weeklyData['57'] : '',
                        'Week6' => $weeklyData['58'] != 0 ? $weeklyData['58'] : '',
                        'Week7' => $weeklyData['59'] != 0 ? $weeklyData['59'] : '',
                        'Week8' => $weeklyData['60'] != 0 ? $weeklyData['60'] : '',
                        'Feb' => collect($weeklyData)->only([57, 58, 59, 60])->sum() != 0 ? collect($weeklyData)->only([57, 58, 59, 60])->sum() : '',
                        'Week9' => $weeklyData['61'] != 0 ? $weeklyData['61'] : '',
                        'Week10' => $weeklyData['62'] != 0 ? $weeklyData['62'] : '',
                        'Week11' => $weeklyData['63'] != 0 ? $weeklyData['63'] : '',
                        'Week12' => $weeklyData['64'] != 0 ? $weeklyData['64'] : '',
                        'Week13' => $weeklyData['65'] != 0 ? $weeklyData['65'] : '',
                        'Mar' => collect($weeklyData)->only([61, 62, 63, 64, 65])->sum() != 0 ? collect($weeklyData)->only([61, 62, 63, 64, 65])->sum() : '',
                        'Week14' => $weeklyData['66'] != 0 ? $weeklyData['66'] : '',
                        'Week15' => $weeklyData['67'] != 0 ? $weeklyData['67'] : '',
                        'Week16' => $weeklyData['68'] != 0 ? $weeklyData['68'] : '',
                        'Week17' => $weeklyData['69'] != 0 ? $weeklyData['69'] : '',
                        'Apr' => collect($weeklyData)->only([66, 67, 68, 69])->sum() != 0 ? collect($weeklyData)->only([66, 67, 68, 69])->sum() : '',
                        'Week18' => $weeklyData['70'] != 0 ? $weeklyData['70'] : '',
                        'Week19' => $weeklyData['71'] != 0 ? $weeklyData['71'] : '',
                        'Week20' => $weeklyData['72'] != 0 ? $weeklyData['72'] : '',
                        'Week21' => $weeklyData['73'] != 0 ? $weeklyData['73'] : '',
                        'May' => collect($weeklyData)->only([70, 71, 72, 73])->sum() != 0 ? collect($weeklyData)->only([70, 71, 72, 73])->sum() : '',
                        'Week22' => $weeklyData['74'] != 0 ? $weeklyData['74'] : '',
                        'Week23' => $weeklyData['75'] != 0 ? $weeklyData['75'] : '',
                        'Week24' => $weeklyData['76'] != 0 ? $weeklyData['76'] : '',
                        'Week25' => $weeklyData['77'] != 0 ? $weeklyData['77'] : '',
                        'Week26' => $weeklyData['78'] != 0 ? $weeklyData['78'] : '',
                        'Jun' => collect($weeklyData)->only([74, 75, 76, 77, 78])->sum() != 0 ? collect($weeklyData)->only([74, 75, 76, 77, 78])->sum() : '',
                        'Week27' => $weeklyData['79'] != 0 ? $weeklyData['79'] : '',
                        'Week28' => $weeklyData['80'] != 0 ? $weeklyData['80'] : '',
                        'Week29' => $weeklyData['81'] != 0 ? $weeklyData['81'] : '',
                        'Week30' => $weeklyData['82'] != 0 ? $weeklyData['82'] : '',
                        'Jul' => collect($weeklyData)->only([79, 80, 81, 82])->sum() != 0 ? collect($weeklyData)->only([79, 80, 81, 82])->sum() : '',
                        'Week31' => $weeklyData['83'] != 0 ? $weeklyData['83'] : '',
                        'Week32' => $weeklyData['84'] != 0 ? $weeklyData['84'] : '',
                        'Week33' => $weeklyData['85'] != 0 ? $weeklyData['85'] : '',
                        'Week34' => $weeklyData['86'] != 0 ? $weeklyData['86'] : '',
                        'Week35' => $weeklyData['87'] != 0 ? $weeklyData['87'] : '',
                        'Aug' => collect($weeklyData)->only([83, 84, 85, 86, 87])->sum() != 0 ? collect($weeklyData)->only([83, 84, 85, 86, 87])->sum() : '',
                        'Week36' => $weeklyData['88'] != 0 ? $weeklyData['88'] : '',
                        'Week37' => $weeklyData['89'] != 0 ? $weeklyData['89'] : '',
                        'Week38' => $weeklyData['90'] != 0 ? $weeklyData['90'] : '',
                        'Week39' => $weeklyData['91'] != 0 ? $weeklyData['91'] : '',
                        'Sep' => collect($weeklyData)->only([88, 89, 90, 91])->sum() != 0 ? collect($weeklyData)->only([88, 89, 90, 91])->sum() : '',
                        'Week40' => $weeklyData['92'] != 0 ? $weeklyData['92'] : '',
                        'Week41' => $weeklyData['93'] != 0 ? $weeklyData['93'] : '',
                        'Week42' => $weeklyData['94'] != 0 ? $weeklyData['94'] : '',
                        'Week43' => $weeklyData['95'] != 0 ? $weeklyData['95'] : '',
                        'Oct' => collect($weeklyData)->only([92, 93, 94, 95])->sum() != 0 ? collect($weeklyData)->only([92, 93, 94, 95])->sum() : '',
                        'Week44' => $weeklyData['96'] != 0 ? $weeklyData['96'] : '',
                        'Week45' => $weeklyData['97'] != 0 ? $weeklyData['97'] : '',
                        'Week46' => $weeklyData['98'] != 0 ? $weeklyData['98'] : '',
                        'Week47' => $weeklyData['99'] != 0 ? $weeklyData['99'] : '',
                        'Week48' => $weeklyData['100'] != 0 ? $weeklyData['100'] : '',
                        'Nov' => collect($weeklyData)->only([96, 97, 98, 99, 100])->sum() != 0 ? collect($weeklyData)->only([96, 97, 98, 99, 100])->sum() : '',
                        'Week49' => $weeklyData['101'] != 0 ? $weeklyData['101'] : '',
                        'Week50' => $weeklyData['102'] != 0 ? $weeklyData['102'] : '',
                        'Week51' => $weeklyData['103'] != 0 ? $weeklyData['103'] : '',
                        'Week52' => $weeklyData['104'] != 0 ? $weeklyData['104'] : '',
                        'Dec' => collect($weeklyData)->only([101, 102, 103, 104])->sum() != 0 ? collect($weeklyData)->only([101, 102, 103, 104])->sum() : '',

                        'GrandTotalByProgram' => $grandTotal,
                    ];
                }
            }
        }

        $grandTotalForAllPrograms = array_sum(array_map('array_sum', $grandTotalByProgram));

        $mappedGroupedClasses[] = [
            'Site' => 'Grand Total',
            'Program' => '',
            'Week1' => $grandTotalByWeek['53'] != 0 ? $grandTotalByWeek['53'] : '',
            'Week2' => $grandTotalByWeek['54'] != 0 ? $grandTotalByWeek['54'] : '',
            'Week3' => $grandTotalByWeek['55'] != 0 ? $grandTotalByWeek['55'] : '',
            'Week4' => $grandTotalByWeek['56'] != 0 ? $grandTotalByWeek['56'] : '',
            'Jan' => collect($grandTotalByWeek)->only([53, 54, 55, 56])->sum() != 0 ? collect($grandTotalByWeek)->only([53, 54, 55, 56])->sum() : '',
            'Week5' => $grandTotalByWeek['57'] != 0 ? $grandTotalByWeek['57'] : '',
            'Week6' => $grandTotalByWeek['58'] != 0 ? $grandTotalByWeek['58'] : '',
            'Week7' => $grandTotalByWeek['59'] != 0 ? $grandTotalByWeek['59'] : '',
            'Week8' => $grandTotalByWeek['60'] != 0 ? $grandTotalByWeek['60'] : '',
            'Feb' => collect($grandTotalByWeek)->only([57, 58, 59, 60])->sum() != 0 ? collect($grandTotalByWeek)->only([57, 58, 59, 60])->sum() : '',
            'Week9' => $grandTotalByWeek['61'] != 0 ? $grandTotalByWeek['61'] : '',
            'Week10' => $grandTotalByWeek['62'] != 0 ? $grandTotalByWeek['62'] : '',
            'Week11' => $grandTotalByWeek['63'] != 0 ? $grandTotalByWeek['63'] : '',
            'Week12' => $grandTotalByWeek['64'] != 0 ? $grandTotalByWeek['64'] : '',
            'Week13' => $grandTotalByWeek['65'] != 0 ? $grandTotalByWeek['65'] : '',
            'Mar' => collect($grandTotalByWeek)->only([61, 62, 63, 64, 65])->sum() != 0 ? collect($grandTotalByWeek)->only([61, 62, 63, 64, 65])->sum() : '',
            'Week14' => $grandTotalByWeek['66'] != 0 ? $grandTotalByWeek['66'] : '',
            'Week15' => $grandTotalByWeek['67'] != 0 ? $grandTotalByWeek['67'] : '',
            'Week16' => $grandTotalByWeek['68'] != 0 ? $grandTotalByWeek['68'] : '',
            'Week17' => $grandTotalByWeek['69'] != 0 ? $grandTotalByWeek['69'] : '',
            'Apr' => collect($grandTotalByWeek)->only([66, 67, 68, 69])->sum() != 0 ? collect($grandTotalByWeek)->only([66, 67, 68, 69])->sum() : '',
            'Week18' => $grandTotalByWeek['70'] != 0 ? $grandTotalByWeek['70'] : '',
            'Week19' => $grandTotalByWeek['71'] != 0 ? $grandTotalByWeek['71'] : '',
            'Week20' => $grandTotalByWeek['72'] != 0 ? $grandTotalByWeek['72'] : '',
            'Week21' => $grandTotalByWeek['73'] != 0 ? $grandTotalByWeek['73'] : '',
            'May' => collect($grandTotalByWeek)->only([70, 71, 72, 73])->sum() != 0 ? collect($grandTotalByWeek)->only([70, 71, 72, 73])->sum() : '',
            'Week22' => $grandTotalByWeek['74'] != 0 ? $grandTotalByWeek['74'] : '',
            'Week23' => $grandTotalByWeek['75'] != 0 ? $grandTotalByWeek['75'] : '',
            'Week24' => $grandTotalByWeek['76'] != 0 ? $grandTotalByWeek['76'] : '',
            'Week25' => $grandTotalByWeek['77'] != 0 ? $grandTotalByWeek['77'] : '',
            'Week26' => $grandTotalByWeek['78'] != 0 ? $grandTotalByWeek['78'] : '',
            'Jun' => collect($grandTotalByWeek)->only([74, 75, 76, 77, 78])->sum() != 0 ? collect($grandTotalByWeek)->only([74, 75, 76, 77, 78])->sum() : '',
            'Week27' => $grandTotalByWeek['79'] != 0 ? $grandTotalByWeek['79'] : '',
            'Week28' => $grandTotalByWeek['80'] != 0 ? $grandTotalByWeek['80'] : '',
            'Week29' => $grandTotalByWeek['81'] != 0 ? $grandTotalByWeek['81'] : '',
            'Week30' => $grandTotalByWeek['82'] != 0 ? $grandTotalByWeek['82'] : '',
            'Jul' => collect($grandTotalByWeek)->only([79, 80, 81, 82])->sum() != 0 ? collect($grandTotalByWeek)->only([79, 80, 81, 82])->sum() : '',
            'Week31' => $grandTotalByWeek['83'] != 0 ? $grandTotalByWeek['83'] : '',
            'Week32' => $grandTotalByWeek['84'] != 0 ? $grandTotalByWeek['84'] : '',
            'Week33' => $grandTotalByWeek['85'] != 0 ? $grandTotalByWeek['85'] : '',
            'Week34' => $grandTotalByWeek['86'] != 0 ? $grandTotalByWeek['86'] : '',
            'Week35' => $grandTotalByWeek['87'] != 0 ? $grandTotalByWeek['87'] : '',
            'Aug' => collect($grandTotalByWeek)->only([83, 84, 85, 86, 87])->sum() != 0 ? collect($grandTotalByWeek)->only([83, 84, 85, 86, 87])->sum() : '',
            'Week36' => $grandTotalByWeek['88'] != 0 ? $grandTotalByWeek['88'] : '',
            'Week37' => $grandTotalByWeek['89'] != 0 ? $grandTotalByWeek['89'] : '',
            'Week38' => $grandTotalByWeek['90'] != 0 ? $grandTotalByWeek['90'] : '',

            'Week39' => $grandTotalByWeek['91'] != 0 ? $grandTotalByWeek['91'] : '',
            'Sep' => collect($grandTotalByWeek)->only([88, 89, 90, 91])->sum() != 0 ? collect($grandTotalByWeek)->only([88, 89, 90, 91])->sum() : '',
            'Week40' => $grandTotalByWeek['92'] != 0 ? $grandTotalByWeek['92'] : '',
            'Week41' => $grandTotalByWeek['93'] != 0 ? $grandTotalByWeek['93'] : '',
            'Week42' => $grandTotalByWeek['94'] != 0 ? $grandTotalByWeek['94'] : '',
            'Week43' => $grandTotalByWeek['95'] != 0 ? $grandTotalByWeek['95'] : '',
            'Oct' => collect($grandTotalByWeek)->only([92, 93, 94, 95])->sum() != 0 ? collect($grandTotalByWeek)->only([92, 93, 94, 95])->sum() : '',
            'Week44' => $grandTotalByWeek['96'] != 0 ? $grandTotalByWeek['96'] : '',
            'Week45' => $grandTotalByWeek['97'] != 0 ? $grandTotalByWeek['97'] : '',
            'Week46' => $grandTotalByWeek['98'] != 0 ? $grandTotalByWeek['98'] : '',
            'Week47' => $grandTotalByWeek['99'] != 0 ? $grandTotalByWeek['99'] : '',
            'Week48' => $grandTotalByWeek['100'] != 0 ? $grandTotalByWeek['100'] : '',
            'Nov' => collect($grandTotalByWeek)->only([96, 97, 98, 99, 100])->sum() != 0 ? collect($grandTotalByWeek)->only([96, 97, 98, 99, 100])->sum() : '',
            'Week49' => $grandTotalByWeek['101'] != 0 ? $grandTotalByWeek['101'] : '',
            'Week50' => $grandTotalByWeek['102'] != 0 ? $grandTotalByWeek['102'] : '',
            'Week51' => $grandTotalByWeek['103'] != 0 ? $grandTotalByWeek['103'] : '',
            'Week52' => $grandTotalByWeek['104'] != 0 ? $grandTotalByWeek['104'] : '',
            'Dec' => collect($grandTotalByWeek)->only([101, 102, 103, 104])->sum() != 0 ? collect($grandTotalByWeek)->only([101, 102, 103, 104])->sum() : '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];

        return $mappedGroupedClasses;
    }

    /*  public function sendEmail(Request $request)
    {
    $mappedGroupedClasses = $this->retrieveDataForEmail();
    $mappedClasses = $this->retrieveDataForClassesEmail();
    $mappedB2Classes = $this->retrieveB2DataForEmail();

    $recipients = ['kryss.bartolome@vxi.com', 'arielito.pascua@vxi.com', 'Philipino.Mercado@vxi.com', 'Aina.Dytioco@vxi.com', 'Ann.Gomez@vxi.com', 'Jemalyn.Fabiano@vxi.com', 'Kathryn.Olis@vxi.com', 'Jay.Juliano@vxi.com', 'Yen.Gelido-Alejandro@vxi.com'];
    $subject = 'PH TA Capacity File - as of ' . date('F j, Y');

    Mail::send('email', ['mappedGroupedClasses' => $mappedGroupedClasses, 'mappedClasses' => $mappedClasses, 'mappedB2Classes' => $mappedB2Classes], function ($message) use ($recipients, $subject) {
    $message->from('TA.Insights@vxi.com', 'TA Reports');
    $message->to($recipients);
    $message->subject($subject);
    });

    return response()->json(['message' => 'Email sent successfully']);
    } */

    public function sendSR(Request $request)
    {
        $mappedResult = $this->srComplianceExport();
        $formattedResult = $this->AutomatedSrExport();

        $recipients = ['kryss.bartolome@vxi.com', 'PH_Talent_Acquisition_Leaders@vxi.com', 'PH_Talent_Acquisition_Management_Team@vxi.com'];
        $subject = 'SR Pending Movement - as of ' . date('F j, Y');

        Mail::send('sr_pending_email', ['mappedResult' => $mappedResult, 'formattedResult' => $formattedResult], function ($message) use ($recipients, $subject) {
            $message->from('TA.Insights@vxi.com', 'TA Reports');
            $message->to($recipients);
            $message->subject($subject);
        });

        return response()->json(['message' => 'Email sent successfully']);
    }

    public function retrieveDataForEmail()
    {
        $programs = Site::where('is_active', 1)->where('country', 'Philippines')->get();

        $year = 2024;
        $dateRanges = DateRange::select('month_num')->where('year', $year)->groupBy('month_num')->get();

        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByProgram = [];

        foreach ($programs as $program) {
            $siteName = $program->name;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            foreach ($dateRanges as $dateRange) {
                $programId = $program->id;
                $month = $dateRange->month_num;
                $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                    ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                        $subquery->where('month_num', $month)->where('year', $year);
                    })
                    ->whereHas('program', function ($subquery) {
                        $subquery->where('is_active', 1);
                    })
                    ->where('site_id', $programId)
                    ->where('status', 'Active')
                    ->get();

                $totalTarget = $classes->sum('total_target');

                if (!isset($grandTotalByWeek[$month])) {
                    $grandTotalByWeek[$month] = 0;
                }

                $grandTotalByWeek[$month] += $totalTarget;
                $grandTotalByProgram[$siteName] += $totalTarget;

                if (!isset($groupedClasses[$siteName][$month])) {
                    $groupedClasses[$siteName][$month] = ['total_target' => 0];
                }
                $groupedClasses[$siteName][$month]['total_target'] += $totalTarget;
            }
        }

        $mappedGroupedClasses = [];
        foreach ($groupedClasses as $siteName => $siteData) {
            $weeklyData = [
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0, '11' => 0, '12' => 0,
            ];
            foreach ($siteData as $month => $weekData) {
                $weeklyData[$month] = isset($weekData['total_target']) ? $weekData['total_target'] : 0;
            }
            $grandTotal = $grandTotalByProgram[$siteName];
            if ($grandTotal != 0) {
                $mappedGroupedClasses[] = [
                    'Site' => $siteName,
                    'January' => $weeklyData['1'] ?: '',
                    'February' => $weeklyData['2'] ?: '',
                    'March' => $weeklyData['3'] ?: '',
                    'April' => $weeklyData['4'] ?: '',
                    'May' => $weeklyData['5'] ?: '',
                    'June' => $weeklyData['6'] ?: '',
                    'July' => $weeklyData['7'] ?: '',
                    'August' => $weeklyData['8'] ?: '',
                    'September' => $weeklyData['9'] ?: '',
                    'October' => $weeklyData['10'] ?: '',
                    'November' => $weeklyData['11'] ?: '',
                    'December' => $weeklyData['12'] ?: '',
                    'GrandTotalByProgram' => $grandTotal,
                ];
            }
        }

        $grandTotalForAllPrograms = array_sum($grandTotalByProgram);

        $mappedGroupedClasses[] = [
            'Site' => 'Grand Total',
            'January' => $grandTotalByWeek['1'] ?: '',
            'February' => $grandTotalByWeek['2'] ?: '',
            'March' => $grandTotalByWeek['3'] ?: '',
            'April' => $grandTotalByWeek['4'] ?: '',
            'May' => $grandTotalByWeek['5'] ?: '',
            'June' => $grandTotalByWeek['6'] ?: '',
            'July' => $grandTotalByWeek['7'] ?: '',
            'August' => $grandTotalByWeek['8'] ?: '',
            'September' => $grandTotalByWeek['9'] ?: '',
            'October' => $grandTotalByWeek['10'] ?: '',
            'November' => $grandTotalByWeek['11'] ?: '',
            'December' => $grandTotalByWeek['12'] ?: '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];
        return $mappedGroupedClasses;
    }
    public function retrieveInternalForEmail()
    {
        $programs = Site::where('is_active', 1)->where('country', 'Philippines')->get();

        $year = 2024;
        $dateRanges = DateRange::select('month_num')->where('year', $year)->groupBy('month_num')->get();

        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByProgram = [];

        foreach ($programs as $program) {
            $siteName = $program->name;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            foreach ($dateRanges as $dateRange) {
                $programId = $program->id;
                $month = $dateRange->month_num;
                $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                    ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                        $subquery->where('month_num', $month)->where('year', $year);
                    })
                    ->whereHas('program', function ($subquery) {
                        $subquery->where('is_active', 1);
                    })
                    ->where('site_id', $programId)
                    ->where('status', 'Active')
                    ->get();

                $totalTarget = $classes->sum('internal_target');

                if (!isset($grandTotalByWeek[$month])) {
                    $grandTotalByWeek[$month] = 0;
                }

                $grandTotalByWeek[$month] += $totalTarget;
                $grandTotalByProgram[$siteName] += $totalTarget;

                if (!isset($groupedClasses[$siteName][$month])) {
                    $groupedClasses[$siteName][$month] = ['internal_target' => 0];
                }
                $groupedClasses[$siteName][$month]['internal_target'] += $totalTarget;
            }
        }

        $mappedExternalClasses = [];
        foreach ($groupedClasses as $siteName => $siteData) {
            $weeklyData = [
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0, '11' => 0, '12' => 0,
            ];
            foreach ($siteData as $month => $weekData) {
                $weeklyData[$month] = isset($weekData['internal_target']) ? $weekData['internal_target'] : 0;
            }
            $grandTotal = $grandTotalByProgram[$siteName];
            if ($grandTotal != 0) {
                $mappedExternalClasses[] = [
                    'Site' => $siteName,
                    'January' => $weeklyData['1'] ?: '',
                    'February' => $weeklyData['2'] ?: '',
                    'March' => $weeklyData['3'] ?: '',
                    'April' => $weeklyData['4'] ?: '',
                    'May' => $weeklyData['5'] ?: '',
                    'June' => $weeklyData['6'] ?: '',
                    'July' => $weeklyData['7'] ?: '',
                    'August' => $weeklyData['8'] ?: '',
                    'September' => $weeklyData['9'] ?: '',
                    'October' => $weeklyData['10'] ?: '',
                    'November' => $weeklyData['11'] ?: '',
                    'December' => $weeklyData['12'] ?: '',
                    'GrandTotalByProgram' => $grandTotal,
                ];
            }
        }

        $grandTotalForAllPrograms = array_sum($grandTotalByProgram);

        $mappedExternalClasses[] = [
            'Site' => 'Grand Total',
            'January' => $grandTotalByWeek['1'] ?: '',
            'February' => $grandTotalByWeek['2'] ?: '',
            'March' => $grandTotalByWeek['3'] ?: '',
            'April' => $grandTotalByWeek['4'] ?: '',
            'May' => $grandTotalByWeek['5'] ?: '',
            'June' => $grandTotalByWeek['6'] ?: '',
            'July' => $grandTotalByWeek['7'] ?: '',
            'August' => $grandTotalByWeek['8'] ?: '',
            'September' => $grandTotalByWeek['9'] ?: '',
            'October' => $grandTotalByWeek['10'] ?: '',
            'November' => $grandTotalByWeek['11'] ?: '',
            'December' => $grandTotalByWeek['12'] ?: '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];
        return $mappedExternalClasses;
    }
    public function retrieveExternalForEmail()
    {
        $programs = Site::where('is_active', 1)->where('country', 'Philippines')->get();

        $year = 2024;
        $dateRanges = DateRange::select('month_num')->where('year', $year)->groupBy('month_num')->get();

        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByProgram = [];

        foreach ($programs as $program) {
            $siteName = $program->name;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            foreach ($dateRanges as $dateRange) {
                $programId = $program->id;
                $month = $dateRange->month_num;
                $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                    ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                        $subquery->where('month_num', $month)->where('year', $year);
                    })
                    ->whereHas('program', function ($subquery) {
                        $subquery->where('is_active', 1);
                    })
                    ->where('site_id', $programId)
                    ->where('status', 'Active')
                    ->get();

                $totalTarget = $classes->sum('external_target');

                if (!isset($grandTotalByWeek[$month])) {
                    $grandTotalByWeek[$month] = 0;
                }

                $grandTotalByWeek[$month] += $totalTarget;
                $grandTotalByProgram[$siteName] += $totalTarget;

                if (!isset($groupedClasses[$siteName][$month])) {
                    $groupedClasses[$siteName][$month] = ['external_target' => 0];
                }
                $groupedClasses[$siteName][$month]['external_target'] += $totalTarget;
            }
        }

        $mappedExternalClasses = [];
        foreach ($groupedClasses as $siteName => $siteData) {
            $weeklyData = [
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0, '11' => 0, '12' => 0,
            ];
            foreach ($siteData as $month => $weekData) {
                $weeklyData[$month] = isset($weekData['external_target']) ? $weekData['external_target'] : 0;
            }
            $grandTotal = $grandTotalByProgram[$siteName];
            if ($grandTotal != 0) {
                $mappedExternalClasses[] = [
                    'Site' => $siteName,
                    'January' => $weeklyData['1'] ?: '',
                    'February' => $weeklyData['2'] ?: '',
                    'March' => $weeklyData['3'] ?: '',
                    'April' => $weeklyData['4'] ?: '',
                    'May' => $weeklyData['5'] ?: '',
                    'June' => $weeklyData['6'] ?: '',
                    'July' => $weeklyData['7'] ?: '',
                    'August' => $weeklyData['8'] ?: '',
                    'September' => $weeklyData['9'] ?: '',
                    'October' => $weeklyData['10'] ?: '',
                    'November' => $weeklyData['11'] ?: '',
                    'December' => $weeklyData['12'] ?: '',
                    'GrandTotalByProgram' => $grandTotal,
                ];
            }
        }

        $grandTotalForAllPrograms = array_sum($grandTotalByProgram);

        $mappedExternalClasses[] = [
            'Site' => 'Grand Total',
            'January' => $grandTotalByWeek['1'] ?: '',
            'February' => $grandTotalByWeek['2'] ?: '',
            'March' => $grandTotalByWeek['3'] ?: '',
            'April' => $grandTotalByWeek['4'] ?: '',
            'May' => $grandTotalByWeek['5'] ?: '',
            'June' => $grandTotalByWeek['6'] ?: '',
            'July' => $grandTotalByWeek['7'] ?: '',
            'August' => $grandTotalByWeek['8'] ?: '',
            'September' => $grandTotalByWeek['9'] ?: '',
            'October' => $grandTotalByWeek['10'] ?: '',
            'November' => $grandTotalByWeek['11'] ?: '',
            'December' => $grandTotalByWeek['12'] ?: '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];
        return $mappedExternalClasses;
    }
    //sr
    public function srComplianceExport()
    {
        $appstepIDs = [1, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 32, 33, 34, 36, 40, 41, 42, 43, 44, 45, 46, 50, 53, 54, 55, 56, 59, 60, 69, 70, 73, 74, 78, 80, 81, 87, 88];

        $latestDate = SmartRecruitData::on('secondary_sqlsrv')->max('last_update_date');

        $query = SmartRecruitData::on('secondary_sqlsrv')
            ->select('Step', 'AppStep', 'Site', DB::raw('COUNT(*) as Count'))
            ->groupBy('Step', 'AppStep', 'Site')
            ->orderBy('Step')
            ->orderBy('AppStep')
            ->whereIn('ApplicationStepStatusId', $appstepIDs)
            ->where(function ($query) use ($latestDate) {
                $query->where('QueueDate', '>=', '20240101')
                    ->where('QueueDate', '<=', $latestDate);
            })
            ->orderBy('Site');

        $result = $query->get();
        $groupedData = [];
        $totalStepCounts = [];
        $totalAppStepCounts = [];
        $totalSiteCounts = [];

        foreach ($result as $item) {
            $step = $item->Step;
            $appStep = $item->AppStep;
            $site = $item->Site;

            if (!isset($groupedData[$step][$appStep])) {
                $groupedData[$step][$appStep] = [
                    'Bridgetowne' => 0,
                    'Clark' => 0,
                    'Davao' => 0,
                    'Makati' => 0,
                    'MOA' => 0,
                    'QC North EDSA' => 0,
                ];
            }

            $groupedData[$step][$appStep][$site] += $item->Count;
            $totalStepCounts[$step] = isset($totalStepCounts[$step]) ? $totalStepCounts[$step] + $item->Count : $item->Count;
            $totalAppStepCounts[$step][$appStep] = isset($totalAppStepCounts[$step][$appStep]) ? $totalAppStepCounts[$step][$appStep] + $item->Count : $item->Count;
            $totalSiteCounts[$step][$site] = (isset($item->Count) && $item->Count > 0) ? (isset($totalSiteCounts[$step][$site]) ? $totalSiteCounts[$step][$site] + $item->Count : $item->Count) : 0;
        }

        $formattedResult = [];
        $maxAppSteps = [];
        $mappedResult = [];

        foreach ($groupedData as $step => $appSteps) {
            $maxAppStep = null;
            $maxAppStepCount = 0;

            foreach ($appSteps as $appStep => $siteCounts) {
                $totalCount = $totalAppStepCounts[$step][$appStep];

                if ($totalCount > $maxAppStepCount) {
                    $maxAppStepCount = $totalCount;
                    $maxAppStep = $appStep;
                }
            }

            $maxAppSteps[$step] = $maxAppStep;

            $formattedSiteCounts = [];
            if ($maxAppStep !== null) {
                foreach ($appSteps[$maxAppStep] as $site => $count) {
                    $formattedSiteCounts[$site] = number_format($count);
                }

                $formattedResult[] = array_merge(
                    ['Step' => $step, 'MaxAppStep' => $maxAppStep, 'MaxAppStepCount' => number_format($totalAppStepCounts[$step][$maxAppStep]), 'StepName' => $step],
                    $formattedSiteCounts
                );
                $mappedResult['2. ONLINE ASSESSMENT'] = [
                    'MaxAppStep' => isset($formattedResult[0]) ? $formattedResult[0]['MaxAppStep'] : null,
                    'MaxAppStepCount' => isset($formattedResult[0]) ? $formattedResult[0]['MaxAppStepCount'] : null,
                    'Bridgetowne' => isset($formattedResult[0]) ? $formattedResult[0]['Bridgetowne'] : null,
                    'Clark' => isset($formattedResult[0]) ? $formattedResult[0]['Clark'] : null,
                    'Davao' => isset($formattedResult[0]) ? $formattedResult[0]['Davao'] : null,
                    'Makati' => isset($formattedResult[0]) ? $formattedResult[0]['Makati'] : null,
                    'MOA' => isset($formattedResult[0]) ? $formattedResult[0]['MOA'] : null,
                    'QC North EDSA' => isset($formattedResult[0]) ? $formattedResult[0]['QC North EDSA'] : null,
                    'TotalCount' => isset($totalStepCounts['2. ONLINE ASSESSMENT']) ? number_format($totalStepCounts['2. ONLINE ASSESSMENT']) : null,
                ];
                $mappedResult['3. INITIAL INTERVIEW'] = [
                    'MaxAppStep' => isset($formattedResult[1]) ? $formattedResult[1]['MaxAppStep'] : null,
                    'MaxAppStepCount' => isset($formattedResult[1]) ? $formattedResult[1]['MaxAppStepCount'] : null,
                    'Bridgetowne' => isset($formattedResult[1]) ? $formattedResult[1]['Bridgetowne'] : null,
                    'Clark' => isset($formattedResult[1]) ? $formattedResult[1]['Clark'] : null,
                    'Davao' => isset($formattedResult[1]) ? $formattedResult[1]['Davao'] : null,
                    'Makati' => isset($formattedResult[1]) ? $formattedResult[1]['Makati'] : null,
                    'MOA' => isset($formattedResult[1]) ? $formattedResult[1]['MOA'] : null,
                    'QC North EDSA' => isset($formattedResult[1]) ? $formattedResult[1]['QC North EDSA'] : null,
                    'TotalCount' => isset($totalStepCounts['3. INITIAL INTERVIEW']) ? number_format($totalStepCounts['3. INITIAL INTERVIEW']) : null,
                ];
                $mappedResult['4. BEHAVIORAL INTERVIEW'] = [
                    'MaxAppStep' => isset($formattedResult[2]) ? $formattedResult[2]['MaxAppStep'] : null,
                    'MaxAppStepCount' => isset($formattedResult[2]) ? $formattedResult[2]['MaxAppStepCount'] : null,
                    'Bridgetowne' => isset($formattedResult[2]) ? $formattedResult[2]['Bridgetowne'] : null,
                    'Clark' => isset($formattedResult[2]) ? $formattedResult[2]['Clark'] : null,
                    'Davao' => isset($formattedResult[2]) ? $formattedResult[2]['Davao'] : null,
                    'Makati' => isset($formattedResult[2]) ? $formattedResult[2]['Makati'] : null,
                    'MOA' => isset($formattedResult[2]) ? $formattedResult[2]['MOA'] : null,
                    'QC North EDSA' => isset($formattedResult[2]) ? $formattedResult[2]['QC North EDSA'] : null,
                    'TotalCount' => isset($totalStepCounts['4. BEHAVIORAL INTERVIEW']) ? number_format($totalStepCounts['4. BEHAVIORAL INTERVIEW']) : null,
                ];
                $mappedResult['5. OPERATIONS VALIDATION'] = [
                    'MaxAppStep' => isset($formattedResult[3]) ? $formattedResult[3]['MaxAppStep'] : null,
                    'MaxAppStepCount' => isset($formattedResult[3]) ? $formattedResult[3]['MaxAppStepCount'] : null,
                    'Bridgetowne' => isset($formattedResult[3]) ? $formattedResult[3]['Bridgetowne'] : null,
                    'Clark' => isset($formattedResult[3]) ? $formattedResult[3]['Clark'] : null,
                    'Davao' => isset($formattedResult[3]) ? $formattedResult[3]['Davao'] : null,
                    'Makati' => isset($formattedResult[3]) ? $formattedResult[3]['Makati'] : null,
                    'MOA' => isset($formattedResult[3]) ? $formattedResult[3]['MOA'] : null,
                    'QC North EDSA' => isset($formattedResult[3]) ? $formattedResult[3]['QC North EDSA'] : null,
                    'TotalCount' => isset($totalStepCounts['5. OPERATIONS VALIDATION']) ? number_format($totalStepCounts['5. OPERATIONS VALIDATION']) : null,
                ];
                $mappedResult['6. LANGUAGE ASSESSMENT'] = [
                    'MaxAppStep' => isset($formattedResult[4]) ? $formattedResult[4]['MaxAppStep'] : null,
                    'MaxAppStepCount' => isset($formattedResult[4]) ? $formattedResult[4]['MaxAppStepCount'] : null,
                    'Bridgetowne' => isset($formattedResult[4]) ? $formattedResult[4]['Bridgetowne'] : null,
                    'Clark' => isset($formattedResult[4]) ? $formattedResult[4]['Clark'] : null,
                    'Davao' => isset($formattedResult[4]) ? $formattedResult[4]['Davao'] : null,
                    'Makati' => isset($formattedResult[4]) ? $formattedResult[4]['Makati'] : null,
                    'MOA' => isset($formattedResult[4]) ? $formattedResult[4]['MOA'] : null,
                    'QC North EDSA' => isset($formattedResult[4]) ? $formattedResult[4]['QC North EDSA'] : null,
                    'TotalCount' => isset($totalStepCounts['6. LANGUAGE ASSESSMENT']) ? number_format($totalStepCounts['6. LANGUAGE ASSESSMENT']) : null,
                ];
            }
        }

        return $mappedResult;
    }
    public function AutomatedSrExport()
    {
        $appstepIDs = [1, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 17, 18, 19, 20, 32, 33, 34, 36, 40, 41, 42, 43, 44, 45, 46, 50, 53, 54, 55, 56, 59, 60, 69, 70, 73, 74, 78, 80, 81, 87, 88];
        $latestDate = SmartRecruitData::on('secondary_sqlsrv')->max('last_update_date');
        $query = SmartRecruitData::on('secondary_sqlsrv')
            ->select('Step', 'AppStep', 'Site', DB::raw('COUNT(*) as Count'))
            ->groupBy('Step', 'AppStep', 'Site')
            ->orderBy('Step')
            ->orderBy('AppStep')
            ->whereIn('ApplicationStepStatusId', $appstepIDs)
            ->whereBetween('QueueDate', ['20240101', $latestDate])
            ->orderBy('Site');

        $result = $query->get();

        $groupedData = [];
        $totalStepCounts = [];
        $totalAppStepCounts = [];

        $totalSiteCounts = [];

        foreach ($result as $item) {
            $step = $item->Step;
            $appStep = $item->AppStep;
            $site = $item->Site;

            if (!isset($groupedData[$step][$appStep])) {
                $groupedData[$step][$appStep] = [
                    'Bridgetowne' => 0,
                    'Clark' => 0,
                    'Davao' => 0,
                    'Makati' => 0,
                    'MOA' => 0,
                    'QC North EDSA' => 0,
                ];
            }

            $groupedData[$step][$appStep][$site] += $item->Count;
            $totalStepCounts[$step] = isset($totalStepCounts[$step]) ? $totalStepCounts[$step] + $item->Count : $item->Count;
            $totalAppStepCounts[$step][$appStep] = isset($totalAppStepCounts[$step][$appStep]) ? $totalAppStepCounts[$step][$appStep] + $item->Count : $item->Count;
            $totalSiteCounts[$step][$site] = (isset($item->Count) && $item->Count > 0) ? (isset($totalSiteCounts[$step][$site]) ? $totalSiteCounts[$step][$site] + $item->Count : $item->Count) : 0;
        }

        foreach ($groupedData as $step => $appSteps) {
            $formattedTotalSiteCounts = [];
            foreach ($totalSiteCounts[$step] as $site => $count) {
                $formattedTotalSiteCounts[$site] = number_format($count);
            }

            $formattedResult[] = array_merge(
                ['Step' => $step, 'TotalCount' => number_format($totalStepCounts[$step])],
                $formattedTotalSiteCounts
            );

            foreach ($appSteps as $appStep => $siteCounts) {
                $formattedSiteCounts = [];
                foreach ($siteCounts as $site => $count) {
                    $formattedSiteCounts[$site] = number_format($count);
                }

                $formattedResult[] = array_merge(
                    ['AppStep' => $appStep, 'TotalCount' => number_format($totalAppStepCounts[$step][$appStep]), 'StepName' => $step],
                    $formattedSiteCounts
                );
            }
        }

        return $formattedResult;
    }
    //capfile
    public function retrieveDataForClassesEmail()
    {
        $programs = Program::with('site')->when(true, function ($query) {
            $query->whereHas('site', function ($subquery) {
                $subquery->where('is_active', 1)->where('country', 'Philippines');
            });
        })

            ->where('is_active', 1) // You ckeep or remove this line based on your requirements
            ->get();

        $year = 2024;
        $dateRanges = DateRange::where('year', $year)
            ->get();

        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByMonth = [];
        $grandTotalByProgram = [];

        foreach ($programs as $program) {
            $siteName = $program->site->name;
            $programName = $program->name;

            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = [];
            }
            $grandTotalByProgram[$siteName][$programName] = 0;

            foreach ($dateRanges as $dateRange) {
                $programId = $program->id;
                $week = $dateRange->id;
                $month = $dateRange->month;

                $classes = Classes::where('site_id', $program->site_id)
                    ->where('program_id', $programId)
                    ->where('date_range_id', $dateRange->id)
                    ->where('status', 'Active')
                    ->get();

                $totalTarget = $classes->sum('total_target');

                if (!isset($grandTotalByWeek[$week])) {
                    $grandTotalByWeek[$week] = 0;
                }
                if (!isset($grandTotalByMonth[$month])) {
                    $grandTotalByMonth[$month] = 0;
                }

                $grandTotalByWeek[$week] += $totalTarget;
                $grandTotalByMonth[$month] += $totalTarget;

                $grandTotalByProgram[$siteName][$programName] += $totalTarget;

                if (!isset($groupedClasses[$siteName][$programName][$week])) {
                    $groupedClasses[$siteName][$programName][$week] = [
                        'total_target' => 0,
                    ];
                }
                if (!isset($groupedClasses[$siteName][$programName][$month])) {
                    $groupedClasses[$siteName][$programName][$month] = [
                        'total_target' => 0,
                    ];
                }

                $groupedClasses[$siteName][$programName][$week]['total_target'] += $totalTarget;
            }
        }

        $mappedClasses = [];

        foreach ($groupedClasses as $siteName => $siteData) {
            foreach ($siteData as $programName => $programData) {
                $weeklyData = [
                    '53' => 0,
                    '54' => 0,
                    '55' => 0,
                    '56' => 0,
                    '57' => 0,
                    '58' => 0,
                    '59' => 0,
                    '60' => 0,
                    '61' => 0,
                    '62' => 0,
                    '63' => 0,
                    '64' => 0,
                    '65' => 0,
                    '66' => 0,
                    '67' => 0,
                    '68' => 0,
                    '69' => 0,
                    '70' => 0,
                    '71' => 0,
                    '72' => 0,
                    '73' => 0,
                    '74' => 0,
                    '75' => 0,
                    '76' => 0,
                    '77' => 0,
                    '78' => 0,
                    '79' => 0,
                    '80' => 0,
                    '81' => 0,
                    '82' => 0,
                    '83' => 0,
                    '84' => 0,
                    '85' => 0,
                    '86' => 0,
                    '87' => 0,
                    '88' => 0,
                    '89' => 0,
                    '90' => 0,
                    '91' => 0,
                    '92' => 0,
                    '93' => 0,
                    '94' => 0,
                    '95' => 0,
                    '96' => 0,
                    '97' => 0,
                    '98' => 0,
                    '99' => 0,
                    '100' => 0,
                    '101' => 0,
                    '102' => 0,
                    '103' => 0,
                    '104' => 0,
                ];

                foreach ($programData as $week => $weekData) {
                    $weeklyData[$week] = isset($weekData['total_target']) ? $weekData['total_target'] : 0;
                }
                $grandTotal = $grandTotalByProgram[$siteName][$programName];
                if ($grandTotal != 0) {
                    $mappedClasses[] = [
                        'Site' => $siteName,
                        'Program' => $programName,
                        'Week1' => $weeklyData['53'] != 0 ? $weeklyData['53'] : '',

                        'Week2' => $weeklyData['54'] != 0 ? $weeklyData['54'] : '',
                        'Week3' => $weeklyData['55'] != 0 ? $weeklyData['55'] : '',
                        'Week4' => $weeklyData['56'] != 0 ? $weeklyData['56'] : '',
                        'Jan' => collect($weeklyData)->only([53, 54, 55, 56])->sum() != 0 ? collect($weeklyData)->only([53, 54, 55, 56])->sum() : '',
                        'Week5' => $weeklyData['57'] != 0 ? $weeklyData['57'] : '',
                        'Week6' => $weeklyData['58'] != 0 ? $weeklyData['58'] : '',
                        'Week7' => $weeklyData['59'] != 0 ? $weeklyData['59'] : '',
                        'Week8' => $weeklyData['60'] != 0 ? $weeklyData['60'] : '',
                        'Feb' => collect($weeklyData)->only([57, 58, 59, 60])->sum() != 0 ? collect($weeklyData)->only([57, 58, 59, 60])->sum() : '',
                        'Week9' => $weeklyData['61'] != 0 ? $weeklyData['61'] : '',
                        'Week10' => $weeklyData['62'] != 0 ? $weeklyData['62'] : '',
                        'Week11' => $weeklyData['63'] != 0 ? $weeklyData['63'] : '',
                        'Week12' => $weeklyData['64'] != 0 ? $weeklyData['64'] : '',
                        'Week13' => $weeklyData['65'] != 0 ? $weeklyData['65'] : '',
                        'Mar' => collect($weeklyData)->only([61, 62, 63, 64, 65])->sum() != 0 ? collect($weeklyData)->only([61, 62, 63, 64, 65])->sum() : '',
                        'Week14' => $weeklyData['66'] != 0 ? $weeklyData['66'] : '',
                        'Week15' => $weeklyData['67'] != 0 ? $weeklyData['67'] : '',
                        'Week16' => $weeklyData['68'] != 0 ? $weeklyData['68'] : '',
                        'Week17' => $weeklyData['69'] != 0 ? $weeklyData['69'] : '',
                        'Apr' => collect($weeklyData)->only([66, 67, 68, 69])->sum() != 0 ? collect($weeklyData)->only([66, 67, 68, 69])->sum() : '',
                        'Week18' => $weeklyData['70'] != 0 ? $weeklyData['70'] : '',
                        'Week19' => $weeklyData['71'] != 0 ? $weeklyData['71'] : '',
                        'Week20' => $weeklyData['72'] != 0 ? $weeklyData['72'] : '',
                        'Week21' => $weeklyData['73'] != 0 ? $weeklyData['73'] : '',
                        'May' => collect($weeklyData)->only([70, 71, 72, 73])->sum() != 0 ? collect($weeklyData)->only([70, 71, 72, 73])->sum() : '',
                        'Week22' => $weeklyData['74'] != 0 ? $weeklyData['74'] : '',
                        'Week23' => $weeklyData['75'] != 0 ? $weeklyData['75'] : '',
                        'Week24' => $weeklyData['76'] != 0 ? $weeklyData['76'] : '',
                        'Week25' => $weeklyData['77'] != 0 ? $weeklyData['77'] : '',
                        'Week26' => $weeklyData['78'] != 0 ? $weeklyData['78'] : '',
                        'Jun' => collect($weeklyData)->only([74, 75, 76, 77, 78])->sum() != 0 ? collect($weeklyData)->only([74, 75, 76, 77, 78])->sum() : '',
                        'Week27' => $weeklyData['79'] != 0 ? $weeklyData['79'] : '',
                        'Week28' => $weeklyData['80'] != 0 ? $weeklyData['80'] : '',
                        'Week29' => $weeklyData['81'] != 0 ? $weeklyData['81'] : '',
                        'Week30' => $weeklyData['82'] != 0 ? $weeklyData['82'] : '',
                        'Jul' => collect($weeklyData)->only([79, 80, 81, 82])->sum() != 0 ? collect($weeklyData)->only([79, 80, 81, 82])->sum() : '',
                        'Week31' => $weeklyData['83'] != 0 ? $weeklyData['83'] : '',
                        'Week32' => $weeklyData['84'] != 0 ? $weeklyData['84'] : '',
                        'Week33' => $weeklyData['85'] != 0 ? $weeklyData['85'] : '',
                        'Week34' => $weeklyData['86'] != 0 ? $weeklyData['86'] : '',
                        'Week35' => $weeklyData['87'] != 0 ? $weeklyData['87'] : '',
                        'Aug' => collect($weeklyData)->only([83, 84, 85, 86, 87])->sum() != 0 ? collect($weeklyData)->only([83, 84, 85, 86, 87])->sum() : '',
                        'Week36' => $weeklyData['88'] != 0 ? $weeklyData['88'] : '',
                        'Week37' => $weeklyData['89'] != 0 ? $weeklyData['89'] : '',
                        'Week38' => $weeklyData['90'] != 0 ? $weeklyData['90'] : '',
                        'Week39' => $weeklyData['91'] != 0 ? $weeklyData['91'] : '',
                        'Sep' => collect($weeklyData)->only([88, 89, 90, 91])->sum() != 0 ? collect($weeklyData)->only([88, 89, 90, 91])->sum() : '',
                        'Week40' => $weeklyData['92'] != 0 ? $weeklyData['92'] : '',
                        'Week41' => $weeklyData['93'] != 0 ? $weeklyData['93'] : '',
                        'Week42' => $weeklyData['94'] != 0 ? $weeklyData['94'] : '',
                        'Week43' => $weeklyData['95'] != 0 ? $weeklyData['95'] : '',
                        'Oct' => collect($weeklyData)->only([92, 93, 94, 95])->sum() != 0 ? collect($weeklyData)->only([92, 93, 94, 95])->sum() : '',
                        'Week44' => $weeklyData['96'] != 0 ? $weeklyData['96'] : '',
                        'Week45' => $weeklyData['97'] != 0 ? $weeklyData['97'] : '',
                        'Week46' => $weeklyData['98'] != 0 ? $weeklyData['98'] : '',
                        'Week47' => $weeklyData['99'] != 0 ? $weeklyData['99'] : '',
                        'Week48' => $weeklyData['100'] != 0 ? $weeklyData['100'] : '',
                        'Nov' => collect($weeklyData)->only([96, 97, 98, 99, 100])->sum() != 0 ? collect($weeklyData)->only([96, 97, 98, 99, 100])->sum() : '',
                        'Week49' => $weeklyData['101'] != 0 ? $weeklyData['101'] : '',
                        'Week50' => $weeklyData['102'] != 0 ? $weeklyData['102'] : '',
                        'Week51' => $weeklyData['103'] != 0 ? $weeklyData['103'] : '',
                        'Week52' => $weeklyData['104'] != 0 ? $weeklyData['104'] : '',
                        'Dec' => collect($weeklyData)->only([101, 102, 103, 104])->sum() != 0 ? collect($weeklyData)->only([101, 102, 103, 104])->sum() : '',

                        'GrandTotalByProgram' => $grandTotal,
                    ];
                }
            }
        }

        $grandTotalForAllPrograms = array_sum(array_map('array_sum', $grandTotalByProgram));

        $mappedClasses[] = [
            'Site' => 'Grand Total',
            'Program' => '',
            'Week1' => $grandTotalByWeek['53'] != 0 ? $grandTotalByWeek['53'] : '',
            'Week2' => $grandTotalByWeek['54'] != 0 ? $grandTotalByWeek['54'] : '',
            'Week3' => $grandTotalByWeek['55'] != 0 ? $grandTotalByWeek['55'] : '',
            'Week4' => $grandTotalByWeek['56'] != 0 ? $grandTotalByWeek['56'] : '',
            'Jan' => collect($grandTotalByWeek)->only([53, 54, 55, 56])->sum() != 0 ? collect($grandTotalByWeek)->only([53, 54, 55, 56])->sum() : '',
            'Week5' => $grandTotalByWeek['57'] != 0 ? $grandTotalByWeek['57'] : '',
            'Week6' => $grandTotalByWeek['58'] != 0 ? $grandTotalByWeek['58'] : '',
            'Week7' => $grandTotalByWeek['59'] != 0 ? $grandTotalByWeek['59'] : '',
            'Week8' => $grandTotalByWeek['60'] != 0 ? $grandTotalByWeek['60'] : '',
            'Feb' => collect($grandTotalByWeek)->only([57, 58, 59, 60])->sum() != 0 ? collect($grandTotalByWeek)->only([57, 58, 59, 60])->sum() : '',
            'Week9' => $grandTotalByWeek['61'] != 0 ? $grandTotalByWeek['61'] : '',
            'Week10' => $grandTotalByWeek['62'] != 0 ? $grandTotalByWeek['62'] : '',
            'Week11' => $grandTotalByWeek['63'] != 0 ? $grandTotalByWeek['63'] : '',
            'Week12' => $grandTotalByWeek['64'] != 0 ? $grandTotalByWeek['64'] : '',
            'Week13' => $grandTotalByWeek['65'] != 0 ? $grandTotalByWeek['65'] : '',
            'Mar' => collect($grandTotalByWeek)->only([61, 62, 63, 64, 65])->sum() != 0 ? collect($grandTotalByWeek)->only([61, 62, 63, 64, 65])->sum() : '',
            'Week14' => $grandTotalByWeek['66'] != 0 ? $grandTotalByWeek['66'] : '',
            'Week15' => $grandTotalByWeek['67'] != 0 ? $grandTotalByWeek['67'] : '',
            'Week16' => $grandTotalByWeek['68'] != 0 ? $grandTotalByWeek['68'] : '',
            'Week17' => $grandTotalByWeek['69'] != 0 ? $grandTotalByWeek['69'] : '',
            'Apr' => collect($grandTotalByWeek)->only([66, 67, 68, 69])->sum() != 0 ? collect($grandTotalByWeek)->only([66, 67, 68, 69])->sum() : '',
            'Week18' => $grandTotalByWeek['70'] != 0 ? $grandTotalByWeek['70'] : '',
            'Week19' => $grandTotalByWeek['71'] != 0 ? $grandTotalByWeek['71'] : '',
            'Week20' => $grandTotalByWeek['72'] != 0 ? $grandTotalByWeek['72'] : '',
            'Week21' => $grandTotalByWeek['73'] != 0 ? $grandTotalByWeek['73'] : '',
            'May' => collect($grandTotalByWeek)->only([70, 71, 72, 73])->sum() != 0 ? collect($grandTotalByWeek)->only([70, 71, 72, 73])->sum() : '',
            'Week22' => $grandTotalByWeek['74'] != 0 ? $grandTotalByWeek['74'] : '',
            'Week23' => $grandTotalByWeek['75'] != 0 ? $grandTotalByWeek['75'] : '',
            'Week24' => $grandTotalByWeek['76'] != 0 ? $grandTotalByWeek['76'] : '',
            'Week25' => $grandTotalByWeek['77'] != 0 ? $grandTotalByWeek['77'] : '',
            'Week26' => $grandTotalByWeek['78'] != 0 ? $grandTotalByWeek['78'] : '',
            'Jun' => collect($grandTotalByWeek)->only([74, 75, 76, 77, 78])->sum() != 0 ? collect($grandTotalByWeek)->only([74, 75, 76, 77, 78])->sum() : '',
            'Week27' => $grandTotalByWeek['79'] != 0 ? $grandTotalByWeek['79'] : '',
            'Week28' => $grandTotalByWeek['80'] != 0 ? $grandTotalByWeek['80'] : '',
            'Week29' => $grandTotalByWeek['81'] != 0 ? $grandTotalByWeek['81'] : '',
            'Week30' => $grandTotalByWeek['82'] != 0 ? $grandTotalByWeek['82'] : '',
            'Jul' => collect($grandTotalByWeek)->only([79, 80, 81, 82])->sum() != 0 ? collect($grandTotalByWeek)->only([79, 80, 81, 82])->sum() : '',
            'Week31' => $grandTotalByWeek['83'] != 0 ? $grandTotalByWeek['83'] : '',
            'Week32' => $grandTotalByWeek['84'] != 0 ? $grandTotalByWeek['84'] : '',
            'Week33' => $grandTotalByWeek['85'] != 0 ? $grandTotalByWeek['85'] : '',
            'Week34' => $grandTotalByWeek['86'] != 0 ? $grandTotalByWeek['86'] : '',
            'Week35' => $grandTotalByWeek['87'] != 0 ? $grandTotalByWeek['87'] : '',
            'Aug' => collect($grandTotalByWeek)->only([83, 84, 85, 86, 87])->sum() != 0 ? collect($grandTotalByWeek)->only([83, 84, 85, 86, 87])->sum() : '',
            'Week36' => $grandTotalByWeek['88'] != 0 ? $grandTotalByWeek['88'] : '',
            'Week37' => $grandTotalByWeek['89'] != 0 ? $grandTotalByWeek['89'] : '',
            'Week38' => $grandTotalByWeek['90'] != 0 ? $grandTotalByWeek['90'] : '',

            'Week39' => $grandTotalByWeek['91'] != 0 ? $grandTotalByWeek['91'] : '',
            'Sep' => collect($grandTotalByWeek)->only([88, 89, 90, 91])->sum() != 0 ? collect($grandTotalByWeek)->only([88, 89, 90, 91])->sum() : '',
            'Week40' => $grandTotalByWeek['92'] != 0 ? $grandTotalByWeek['92'] : '',
            'Week41' => $grandTotalByWeek['93'] != 0 ? $grandTotalByWeek['93'] : '',
            'Week42' => $grandTotalByWeek['94'] != 0 ? $grandTotalByWeek['94'] : '',
            'Week43' => $grandTotalByWeek['95'] != 0 ? $grandTotalByWeek['95'] : '',
            'Oct' => collect($grandTotalByWeek)->only([92, 93, 94, 95])->sum() != 0 ? collect($grandTotalByWeek)->only([92, 93, 94, 95])->sum() : '',
            'Week44' => $grandTotalByWeek['96'] != 0 ? $grandTotalByWeek['96'] : '',
            'Week45' => $grandTotalByWeek['97'] != 0 ? $grandTotalByWeek['97'] : '',
            'Week46' => $grandTotalByWeek['98'] != 0 ? $grandTotalByWeek['98'] : '',
            'Week47' => $grandTotalByWeek['99'] != 0 ? $grandTotalByWeek['99'] : '',
            'Week48' => $grandTotalByWeek['100'] != 0 ? $grandTotalByWeek['100'] : '',
            'Nov' => collect($grandTotalByWeek)->only([96, 97, 98, 99, 100])->sum() != 0 ? collect($grandTotalByWeek)->only([96, 97, 98, 99, 100])->sum() : '',
            'Week49' => $grandTotalByWeek['101'] != 0 ? $grandTotalByWeek['101'] : '',
            'Week50' => $grandTotalByWeek['102'] != 0 ? $grandTotalByWeek['102'] : '',
            'Week51' => $grandTotalByWeek['103'] != 0 ? $grandTotalByWeek['103'] : '',
            'Week52' => $grandTotalByWeek['104'] != 0 ? $grandTotalByWeek['104'] : '',
            'Dec' => collect($grandTotalByWeek)->only([101, 102, 103, 104])->sum() != 0 ? collect($grandTotalByWeek)->only([101, 102, 103, 104])->sum() : '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];

        return $mappedClasses;
    }

    public function retrieveB2DataForEmail()
    {
        $programs = Site::where('is_active', 1)->where('country', 'Philippines')->get();
        $year = 2024;
        $dateRanges = DateRange::select('month_num')->where('year', $year)->groupBy('month_num')->get();
        $groupedClasses = [];
        $grandTotalByWeek = [];
        $grandTotalByWeek2 = [];
        $grandTotalByProgram = [];
        $grandTotalByProgram2 = []; // Declare $b2percentage array

        foreach ($programs as $program) {
            $siteName = $program->name;
            if (!isset($grandTotalByProgram[$siteName])) {
                $grandTotalByProgram[$siteName] = 0;
            }
            if (!isset($grandTotalByProgram2[$siteName])) {
                $grandTotalByProgram2[$siteName] = 0;
            }
            foreach ($dateRanges as $dateRange) {
                $month = $dateRange->month_num;
                $classes = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                    ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                        $subquery->where('month_num', $month)->where('year', $year);
                    })
                    ->whereHas('program', function ($subquery) {
                        $subquery->where('is_active', 1)->where('program_type', 'B2')
                            ->orWhere('program_type', 'COMCAST');
                    })
                    ->where('site_id', $program->id)
                    ->where('status', 'Active')
                    ->get();
                $classes2 = Classes::with('site', 'program', 'dateRange', 'createdByUser', 'updatedByUser')
                    ->whereHas('dateRange', function ($subquery) use ($month, $year) {
                        $subquery->where('month_num', $month)->where('year', $year);
                    })
                    ->whereHas('program', function ($subquery) {
                        $subquery->where('is_active', 1);
                    })
                    ->where('site_id', $program->id)
                    ->where('status', 'Active')
                    ->get();
                $totalTarget = $classes->sum('total_target');
                $totalTarget2 = $classes2->sum('total_target');

                if (!isset($grandTotalByWeek[$month])) {
                    $grandTotalByWeek[$month] = 0;
                }
                if (!isset($grandTotalByWeek2[$month])) {
                    $grandTotalByWeek2[$month] = 0;
                }

                $grandTotalByWeek[$month] += $totalTarget;
                $grandTotalByWeek2[$month] += $totalTarget2;
                $grandTotalByProgram[$siteName] += $totalTarget;

                $grandTotalByProgram2[$siteName] += $totalTarget2;

                if (!isset($groupedClasses[$siteName][$month])) {
                    $groupedClasses[$siteName][$month] = ['total_target' => 0];
                }
                $groupedClasses[$siteName][$month]['total_target'] += $totalTarget;
            }
        }
        $grandTotalForAllPrograms = array_sum($grandTotalByProgram);
        $grandTotalForAllPrograms2 = array_sum($grandTotalByProgram2);

        $mappedB2Classes = [];
        $mappedB2Classes[] = [
            'Site' => 'B2 Percentage',
            'January' => $grandTotalByWeek2['1'] != 0 ? round(($grandTotalByWeek['1'] / $grandTotalByWeek2['1']) * 100, 2) . '%' : '0%',
            'February' => $grandTotalByWeek2['2'] != 0 ? round(($grandTotalByWeek['2'] / $grandTotalByWeek2['2']) * 100, 2) . '%' : '0%',
            'March' => $grandTotalByWeek2['3'] != 0 ? round(($grandTotalByWeek['3'] / $grandTotalByWeek2['3']) * 100, 2) . '%' : '0%',
            'April' => $grandTotalByWeek2['4'] != 0 ? round(($grandTotalByWeek['4'] / $grandTotalByWeek2['4']) * 100, 2) . '%' : '0%',
            'May' => $grandTotalByWeek2['5'] != 0 ? round(($grandTotalByWeek['5'] / $grandTotalByWeek2['5']) * 100, 2) . '%' : '0%',
            'June' => $grandTotalByWeek2['6'] != 0 ? round(($grandTotalByWeek['6'] / $grandTotalByWeek2['6']) * 100, 2) . '%' : '0%',
            'July' => $grandTotalByWeek2['7'] != 0 ? round(($grandTotalByWeek['7'] / $grandTotalByWeek2['7']) * 100, 2) . '%' : '0%',
            'August' => $grandTotalByWeek2['8'] != 0 ? round(($grandTotalByWeek['8'] / $grandTotalByWeek2['8']) * 100, 2) . '%' : '0%',
            'September' => $grandTotalByWeek2['9'] != 0 ? round(($grandTotalByWeek['9'] / $grandTotalByWeek2['9']) * 100, 2) . '%' : '0%',
            'October' => $grandTotalByWeek2['10'] != 0 ? round(($grandTotalByWeek['10'] / $grandTotalByWeek2['10']) * 100, 2) . '%' : '0%',
            'November' => $grandTotalByWeek2['11'] != 0 ? round(($grandTotalByWeek['11'] / $grandTotalByWeek2['11']) * 100, 2) . '%' : '0%',
            'December' => $grandTotalByWeek2['12'] != 0 ? round(($grandTotalByWeek['12'] / $grandTotalByWeek2['12']) * 100, 2) . '%' : '0%',
            'GrandTotalByProgram' => $grandTotalForAllPrograms2 != 0 ? round(($grandTotalForAllPrograms / $grandTotalForAllPrograms2) * 100, 2) . '%' : '0%',

        ];
        foreach ($groupedClasses as $siteName => $siteData) {
            $weeklyData = [
                '1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0, '6' => 0, '7' => 0, '8' => 0,
                '9' => 0, '10' => 0, '11' => 0, '12' => 0,
            ];
            foreach ($siteData as $month => $weekData) {
                $weeklyData[$month] = isset($weekData['total_target']) ? $weekData['total_target'] : 0;
            }
            $grandTotal = $grandTotalByProgram[$siteName];
            if ($grandTotal != 0) {
                $mappedB2Classes[] = [
                    'Site' => $siteName,
                    'January' => $weeklyData['1'] ?: '',
                    'February' => $weeklyData['2'] ?: '',
                    'March' => $weeklyData['3'] ?: '',
                    'April' => $weeklyData['4'] ?: '',
                    'May' => $weeklyData['5'] ?: '',
                    'June' => $weeklyData['6'] ?: '',
                    'July' => $weeklyData['7'] ?: '',
                    'August' => $weeklyData['8'] ?: '',
                    'September' => $weeklyData['9'] ?: '',
                    'October' => $weeklyData['10'] ?: '',
                    'November' => $weeklyData['11'] ?: '',
                    'December' => $weeklyData['12'] ?: '',
                    'GrandTotalByProgram' => $grandTotal,
                ];
            }
        }

        $mappedB2Classes[] = [
            'Site' => 'Grand Total',
            'January' => $grandTotalByWeek['1'] ?: '',
            'February' => $grandTotalByWeek['2'] ?: '',
            'March' => $grandTotalByWeek['3'] ?: '',
            'April' => $grandTotalByWeek['4'] ?: '',
            'May' => $grandTotalByWeek['5'] ?: '',
            'June' => $grandTotalByWeek['6'] ?: '',
            'July' => $grandTotalByWeek['7'] ?: '',
            'August' => $grandTotalByWeek['8'] ?: '',
            'September' => $grandTotalByWeek['9'] ?: '',
            'October' => $grandTotalByWeek['10'] ?: '',
            'November' => $grandTotalByWeek['11'] ?: '',
            'December' => $grandTotalByWeek['12'] ?: '',
            'GrandTotalByProgram' => $grandTotalForAllPrograms,
        ];

        return $mappedB2Classes;
    }
}
