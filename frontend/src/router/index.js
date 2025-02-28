import { createRouter, createWebHashHistory } from "vue-router";
import store from "../store";
import AppLogin from "@/views/AppLogin";
import ApplicantChecker from "@/views/ApplicantQr";
import ApplicantAttendanceForm from "@/views/ApplicantAttendanceForm";
import AppUserLayout from "@/components/AppUserLayout";
import AppAdminLayout from "@/components/AppAdminLayout";
import AuthLayout from "@/components/AuthLayout";
import AppAdminDashboard from "@/views/Dashboard/AppAdminDashboard";
import UserManagement from "@/views/DashboardNavItems/Admin/UserManagement";
import UserSiteManagement from "@/views/DashboardNavItems/Admin/UserSiteManagement";
import userProfile from "@/views/DashboardNavItems/Admin/UserProfile.vue";
import programManagementEdit from "@/views/DashboardNavItems/Admin/EditProgram";
import siteManagementEdit from "@/views/DashboardNavItems/Admin/EditSite";
import SiteManagement from "@/views//Dashboard/AppSiteDashboard.vue";
import WebRockData from "@/views//Dashboard/WebRockData.vue";
import capacityFile from "@/views/DashboardNavItems/User/CapacityFile.vue";
import HnS from "@/views/DashboardNavItems/User/HnS.vue";
import Screening from "@/views/DashboardNavItems/User/H&S/HsScreening.vue";
import Interview from "@/views/DashboardNavItems/User/H&S/HsInterview.vue";
import Ov from "@/views/DashboardNavItems/User/H&S/HsOv.vue";
import ProgSpecs from "@/views/DashboardNavItems/User/H&S/HsProgSpecs.vue";
import JobOffer from "@/views/DashboardNavItems/User/H&S/HsJobOffer.vue";
import capacityFileReport from "@/views/DashboardNavItems/User/CapacityFileReport.vue";
import CapFileHiring from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFileHiring.vue";
import CapFileClassHistory from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFileClassHistory";
import CapFileOos from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFileOos";
import CapFileCancelledClass from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFileCancelledClasses.vue";
import CapFilePushedback from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFilePushedback";
import CapFileCancelled from "@/views/DashboardNavItems/User/CapacityFileDashboard/CapFileCancelled";
import addCapacityFile from "@/views/DashboardNavItems/User/Capfile/AddCapfile.vue";
import ProgramManagement from "@/views/Dashboard/AppProgramDashboard.vue";
import pushbackCapacityFile from "@/views/DashboardNavItems/User/Capfile/PushedBackCapacityFile.vue";
import cancelCapacityFile from "@/views/DashboardNavItems/User/Capfile/CancelCapacityFile.vue";
import editCapFile from "@/views/DashboardNavItems/User/Capfile/EditCapfile.vue";
import StaffingTrackerReport from "@/views/DashboardNavItems/User/StaffingTrackerReport.vue";
import StaffingTracker from "@/views/DashboardNavItems/User/StaffingTracker.vue";
import AddStaffingTracker from "@/views/DashboardNavItems/User/AddStaffingTracker.vue";
import UpdateStaffingTracker from "@/views/DashboardNavItems/User/UpdateStaffingTracker.vue";
import inventoryTracker from "@/views/DashboardNavItems/User/InventoryTracker.vue";
import supplyManager from "@/views/DashboardNavItems/User/InventoryTracker/SupplyManager.vue";
import siteSupplyManager from "@/views/DashboardNavItems/User/InventoryTracker/SiteSupplyManager.vue";
import siteSupplyStock from "@/views/DashboardNavItems/User/InventoryTracker/SiteSupplyStock.vue";
import siteTransfer from "@/views/DashboardNavItems/User/InventoryTracker/SiteTransferRequest.vue";
import dashboardManager from "@/views/DashboardNavItems/User/InventoryTracker/DashboardManager.vue";
import dashboardAwarded from "@/views/DashboardNavItems/User/InventoryTracker/DashboardAwarded.vue";
import dashboardRequest from "@/views/DashboardNavItems/User/InventoryTracker/DashboardRequests.vue";
import dashboardSupply from "@/views/DashboardNavItems/User/InventoryTracker/DashboardSupply.vue";
import dashboardSiteSupply from "@/views/DashboardNavItems/User/InventoryTracker/DashboardSiteSupply.vue";
import siteRequestManager from "@/views/DashboardNavItems/User/InventoryTracker/SiteRequestManager.vue";
import siteRequestReceived from "@/views/DashboardNavItems/User/InventoryTracker/SiteRequestReceived.vue";
import siteRequest from "@/views/DashboardNavItems/User/InventoryTracker/SiteRequest.vue";
import awardManager from "@/views/DashboardNavItems/User/InventoryTracker/AwardManager.vue";
import awardNormal from "@/views/DashboardNavItems/User/InventoryTracker/AwardNormal.vue";
import EditAwardNormal from "@/views/DashboardNavItems/User/InventoryTracker/EditAwardNormal.vue";
import EditAwardPremium from "@/views/DashboardNavItems/User/InventoryTracker/EditAwardPremium.vue";
import awardPremium from "@/views/DashboardNavItems/User/InventoryTracker/AwardPremium.vue";
import requestManagerPending from "@/views/DashboardNavItems/User/InventoryTracker/RequestManagerPending.vue";
import requestManagerApproved from "@/views/DashboardNavItems/User/InventoryTracker/RequestManagerApproved.vue";
import requestManagerDenied from "@/views/DashboardNavItems/User/InventoryTracker/RequestManagerDenied.vue";
import requestManagerCancelled from "@/views/DashboardNavItems/User/InventoryTracker/RequestManagerCancelled.vue";
import staffingTrackerMonthDashboard from "@/views/DashboardNavItems/User/StaffingTrackerDashboard/StaffingTrackerMonthDashboard.vue";
import staffingTrackerSiteDashboard from "@/views/DashboardNavItems/User/StaffingTrackerDashboard/StaffingTrackerSiteDashboard.vue";
import staffingTrackerWeekDashboard from "@/views/DashboardNavItems/User/StaffingTrackerDashboard/StaffingTrackerWeekDashboard.vue";
import perxAuditTools from "@/views/DashboardNavItems/User/PerxAuditTools.vue";
import perxAuditToolsv2 from "@/views/DashboardNavItems/User/PerxAuditTools2.vue";
import Applicants from "@/views/DashboardNavItems/User/ApplicantList.vue";
import ClassesInformation from "@/views/DashboardNavItems/User/ClassesInformation.vue";
import ReferralList from "@/views/DashboardNavItems/User/ReferralList.vue";
import Leads from "@/views/DashboardNavItems/User/LeadsTool.vue";
import SrFilterTool from "@/views/DashboardNavItems/User/SrFilterTool.vue";
import SrManager from "@/views/DashboardNavItems/User/SrManager.vue";
import pushbackCapacityFileJamaica from "@/views/DashboardNavItems/User/CapfileJamaica/PushedBackCapacityFileJamaica.vue";
import cancelCapacityFileJamaica from "@/views/DashboardNavItems/User/CapfileJamaica/CancelCapacityFileJamaica.vue";
import editCapFileJamaica from "@/views/DashboardNavItems/User/CapfileJamaica/EditCapfileJamaica.vue";
import pushbackCapacityFileGuatemala from "@/views/DashboardNavItems/User/CapfileGuatemala/PushedBackCapacityFileGuatemala.vue";
import cancelCapacityFileGuatemala from "@/views/DashboardNavItems/User/CapfileGuatemala/CancelCapacityFileGuatemala.vue";
import editCapFileGuatemala from "@/views/DashboardNavItems/User/CapfileGuatemala/EditCapfileGuatemala.vue";
import capacityFileJamaica from "@/views/DashboardNavItems/User/CapacityFileJamaica.vue";
import capacityFileReportJamaica from "@/views/DashboardNavItems/User/CapacityFileReportJamaica.vue";
import CapFileHiringJamaica from "@/views/DashboardNavItems/User/CapacityFileDashboardJamaica/CapFileHiring.vue";
import CapFileClassHistoryJamaica from "@/views/DashboardNavItems/User/CapacityFileDashboardJamaica/CapFileClassHistory";
import CapFilePushedbackJamaica from "@/views/DashboardNavItems/User/CapacityFileDashboardJamaica/CapFilePushedback";
import CapFileCancelledJamaica from "@/views/DashboardNavItems/User/CapacityFileDashboardJamaica/CapFileCancelled";
import capacityFileGuatemala from "@/views/DashboardNavItems/User/CapacityFileGuatemala.vue";
import capacityFileReportGuatemala from "@/views/DashboardNavItems/User/CapacityFileReportGuatemala.vue";
import CapFileHiringGuatemala from "@/views/DashboardNavItems/User/CapacityFileDashboardGuatemala/CapFileHiring.vue";
import CapFileClassHistoryGuatemala from "@/views/DashboardNavItems/User/CapacityFileDashboardGuatemala/CapFileClassHistory";
import CapFilePushedbackGuatemala from "@/views/DashboardNavItems/User/CapacityFileDashboardGuatemala/CapFilePushedback";
import CapFileCancelledGuatemala from "@/views/DashboardNavItems/User/CapacityFileDashboardGuatemala/CapFileCancelled";
import addCapacityFileJamaica from "@/views/DashboardNavItems/User/CapfileJamaica/AddCapfileJamaica.vue";
import addCapacityFileGuatemala from "@/views/DashboardNavItems/User/CapfileGuatemala/AddCapfileGuatemala.vue";
import SiteManagementJamaica from "@/views//Dashboard/AppSiteDashboardJamaica.vue";
import SiteManagementGuatemala from "@/views//Dashboard/AppSiteDashboardGuatemala.vue";
import AppUserLayoutJamaica from "@/components/AppUserLayoutJamaica";
import AppUserLayoutGuatemala from "@/components/AppUserLayoutGuatemala";
import programManagementEditJamaica from "@/views/DashboardNavItems/Admin/EditProgramJamaica";
import siteManagementEditJamaica from "@/views/DashboardNavItems/Admin/EditSiteJamaica";
import programManagementEditGuatemala from "@/views/DashboardNavItems/Admin/EditProgramGuatemala";
import siteManagementEditGuatemala from "@/views/DashboardNavItems/Admin/EditSiteGuatemala";
import ProgramManagementJamaica from "@/views/Dashboard/AppProgramDashboardJamaica.vue";
import ProgramManagementGuatemala from "@/views/Dashboard/AppProgramDashboardGuatemala.vue";
import RemxSupplyManager from "@/views/DashboardNavItems/User/InventoryTracker/RemxSupplyManager.vue";
import remxTransfer from "@/views/DashboardNavItems/User/InventoryTracker/RemxSiteTransferRequest.vue";
import Onboarding from "@/views/DashboardNavItems/User/Onboarding/OnboardingMainPage.vue";
import OnboardingMainPageNew from "@/views/DashboardNavItems/User/Onboarding/OnboardingMainPageNew.vue";
import OnboardingForm from "@/views/DashboardNavItems/User/Onboarding/OnboardingForm.vue";
import OnboardingFormNew from "@/views/DashboardNavItems/User/Onboarding/OnboardingFormNew.vue";
import OnboardingUpdateForm from "@/views/DashboardNavItems/User/Onboarding/OnboardingUpdateForm.vue";
import OnboardingNBI from "@/views/DashboardNavItems/User/Onboarding/OnboardingNBI.vue";
import OnboardingDT from "@/views/DashboardNavItems/User/Onboarding/OnboardingDT.vue";
import OnboardingPEME from "@/views/DashboardNavItems/User/Onboarding/OnboardingPEME.vue";
import OnboardingSSS from "@/views/DashboardNavItems/User/Onboarding/OnboardingSSS.vue";
import OnboardingPHIC from "@/views/DashboardNavItems/User/Onboarding/OnboardingPHIC.vue";
import OnboardingPAGIBIG from "@/views/DashboardNavItems/User/Onboarding/OnboardingPAGIBIG.vue";
import OnboardingTIN from "@/views/DashboardNavItems/User/Onboarding/OnboardingTIN.vue";
import OnboardingHEALTHCERTIFICATE from "@/views/DashboardNavItems/User/Onboarding/OnboardingHEALTHCERTIFICATE.vue";
import OnboardingOCCUPATIONALPERMIT from "@/views/DashboardNavItems/User/Onboarding/OnboardingOCCUPATIONALPERMIT.vue";
import OnboardingOFAC from "@/views/DashboardNavItems/User/Onboarding/OnboardingOFAC.vue";
import OnboardingSAM from "@/views/DashboardNavItems/User/Onboarding/OnboardingSAM.vue";
import OnboardingOIG from "@/views/DashboardNavItems/User/Onboarding/OnboardingOIG.vue";
import OnboardingCIBI from "@/views/DashboardNavItems/User/Onboarding/OnboardingCIBI.vue";
import OnboardingBGC from "@/views/DashboardNavItems/User/Onboarding/OnboardingBGC.vue";
import OnboardingBIRTHCERTIFICATE from "@/views/DashboardNavItems/User/Onboarding/OnboardingBIRTHCERTIFICATE.vue";
import OnboardingMARRIAGECERTIFICATE from "@/views/DashboardNavItems/User/Onboarding/OnboardingMARRIAGECERTIFICATE.vue";
import OnboardingDEPENDENTBIRTHCERTIFICATE from "@/views/DashboardNavItems/User/Onboarding/OnboardingDEPENDENTBIRTHCERTIFICATE.vue";
import OnboardingSCHOLASTIC from "@/views/DashboardNavItems/User/Onboarding/OnboardingSCHOLASTIC.vue";
import OnboardingPREVIOUSEMPLOYMENT from "@/views/DashboardNavItems/User/Onboarding/OnboardingPREVIOUSEMPLOYMENT.vue";
import OnboardingSUPPORTINGDOCUMENT from "@/views/DashboardNavItems/User/Onboarding/OnboardingSUPPORTINGDOCUMENT.vue";
import OnboardingLob from "@/views/DashboardNavItems/User/Onboarding/OnboardingLob.vue";
import OnboardingUpdateSelection from "@/views/DashboardNavItems/User/Onboarding/OnboardingUpdateSelection.vue";
import OnboardingEmployeeProfile from "@/views/DashboardNavItems/User/Onboarding/OnboardingEmployeeProfile.vue";
import OnboardingWorkday from "@/views/DashboardNavItems/User/Onboarding/OnboardingWorkday.vue";
import OnboardingEmployeeInformation from "@/views/DashboardNavItems/User/Onboarding/OnboardingEmployeeInformation.vue";
import ApplicantAttendanceList from "@/views/DashboardNavItems/User/FrontDesk/ApplicantAttendanceList.vue";
import ReferralListv1 from "@/views/DashboardNavItems/User/ReferralListV1.vue";

const routes = [
  {
    path: "/",
    component: AppUserLayout,
    meta: {
      requiresAuth: true,
      requiresRoles: ["user", "remx", "sourcing", "budget","onboarding","frontdesk"],
    },
    children: [
      {
        path: "/profile",
        name: "userProfile",
        component: userProfile,
      },
      {
        path: "/applicant_attendance_list",
        name: "ApplicantAttendanceList",
        component: ApplicantAttendanceList,
      },
      {
        path: "/perx",
        name: "perxAuditTools",
        component: perxAuditTools,
      },
      {
        path: "/perxv2",
        name: "perxAuditToolsv2",
        component: perxAuditToolsv2,
      },
      {
        path: "/leads",
        name: "Leads",
        component: Leads,
      },
      {
        path: "/applicants",
        name: "Applicants",
        component: Applicants,
      },
      {
        path: "/classes_information",
        name: "ClassesInformation",
        component: ClassesInformation,
      },
      {
        path: "/referrals",
        name: "ReferralList",
        component: ReferralList,
      },
      {
        path: "/referralsv1",
        name: "ReferralListv1",
        component: ReferralListv1,
      },
      {
        path: "/user_management",
        name: "usermanagement",
        component: UserManagement,
      },

      {
        path: "/",
        name: "SrManager",
        component: SrManager,
        children: [
          {
            path: "/sr_filter",
            name: "SrFilterTool",
            component: SrFilterTool,
          },
          {
            path: "/sr_compliance",
            name: "WebRockData",
            component: WebRockData,
          },
        ],
      },
      {
        path: "/inventory",
        name: "inventoryTracker",
        component: inventoryTracker,
        children: [
          {
            path: "/dashboard_manager",
            name: "dashboardManager",
            component: dashboardManager,
            children: [
              {
                path: "request",
                name: "dashboardRequest",
                component: dashboardRequest,
              },
              {
                path: "supply",
                name: "dashboardSupply",
                component: dashboardSupply,
              },
              {
                path: "site_supply",
                name: "dashboardSiteSupply",
                component: dashboardSiteSupply,
              },
              {
                path: "awarded",
                name: "dashboardAwarded",
                component: dashboardAwarded,
              },
            ],
          },
          {
            path: "/site_supply_manager",
            name: "siteSupplyManager",
            component: siteSupplyManager,
            children: [
              {
                path: "stocks",
                name: "siteSupplyStock",
                component: siteSupplyStock,
              },
              {
                path: "transfer",
                name: "siteTransfer",
                component: siteTransfer,
              },
            ],
          },
          {
            path: "/remx",
            name: "RemxSupplyManager",
            component: RemxSupplyManager,
            children: [
              {
                path: "supply_manager",
                name: "supplyManager",
                component: supplyManager,
              },
              {
                path: "transfer",
                name: "remxTransfer",
                component: remxTransfer,
              },
            ],
          },
          {
            path: "/site_request_manager",
            name: "siteRequestManager",
            component: siteRequestManager,
            children: [
              {
                path: "request",
                name: "siteRequest",
                component: siteRequest,
              },
              {
                path: "received",
                name: "siteRequestReceived",
                component: siteRequestReceived,
              },
              {
                path: "pending",
                name: "requestManagerPending",
                component: requestManagerPending,
              },
              {
                path: "approved",
                name: "requestManagerApproved",
                component: requestManagerApproved,
              },
              {
                path: "denied",
                name: "requestManagerDenied",
                component: requestManagerDenied,
              },
              {
                path: "cancelled",
                name: "requestManagerCancelled",
                component: requestManagerCancelled,
              },
            ],
          },
          {
            path: "/award_manager",
            name: "awardManager",
            component: awardManager,
            children: [
              {
                path: "normal",
                name: "awardNormal",
                component: awardNormal,
              },
              {
                path: "premium",
                name: "awardPremium",
                component: awardPremium,
              },
              {
                path: "normal/:id",
                name: "EditAwardNormal",
                component: EditAwardNormal,
              },
              {
                path: "premium/:id",
                name: "EditAwardPremium",
                component: EditAwardPremium,
              },
            ],
          },
        ],
      },
      {
        path: "/addstaffing/:id",
        name: "AddStaffingTracker",
        component: AddStaffingTracker,
      },
      {
        path: "/updatestaffing/:id",
        name: "UpdateStaffingTracker",
        component: UpdateStaffingTracker,
      },
      {
        path: "/staffing_report",
        name: "StaffingTrackerReport",
        component: StaffingTrackerReport,
        children: [
          {
            path: "site",
            name: "staffingTrackerSiteDashboard",
            component: staffingTrackerSiteDashboard,
          },
          {
            path: "week",
            name: "staffingTrackerWeekDashboard",
            component: staffingTrackerWeekDashboard,
          },
          {
            path: "month",
            name: "staffingTrackerMonthDashboard",
            component: staffingTrackerMonthDashboard,
          },
          {
            path: "/staffing",
            name: "StaffingTracker",
            component: StaffingTracker,
          },
        ],
      },
      {
        path: "/capfile",
        name: "capacityFileReport",
        component: capacityFileReport,
        children: [
          {
            path: "history",
            name: "CapFileClassHistory",
            component: CapFileClassHistory,
          },
          {
            path: "summary",
            name: "CapFileHiring",
            component: CapFileHiring,
          },
          {
            path: "outofsla",
            name: "CapFileOos",
            component: CapFileOos,
          },
          {
            path: "cancelled",
            name: "CapFileCancelled",
            component: CapFileCancelled,
          },
          {
            path: "moved",
            name: "CapFilePushedback",
            component: CapFilePushedback,
          },
          {
            path: "/capfile",
            name: "capacityFile",
            component: capacityFile,
          },
          {
            path: "/cancelled_list",
            name: "CapFileCancelledClass",
            component: CapFileCancelledClass,
          },
        ],
      },
      {
        path: "/pushbackcapfile/:id",
        name: "pushbackCapacityFile",
        component: pushbackCapacityFile,
      },
      {
        path: "/cancelcapfile/:id",
        name: "cancelCapacityFile",
        component: cancelCapacityFile,
      },
      {
        path: "/editcapfile/:id",
        name: "editCapFile",
        component: editCapFile,
      },
      {
        path: "/addcapfile/:id",
        name: "addCapacityFile",
        component: addCapacityFile,
      },
      {
        path: "/site_management",
        name: "sitemanagement",
        component: SiteManagement,
      },
      {
        path: "/site_management/edit/:id",
        name: "sitemanagementedit",
        component: siteManagementEdit,
      },
      {
        path: "/program_management",
        name: "programmanagement",
        component: ProgramManagement,
      },
      {
        path: "/program_management/edit/:id",
        name: "programmanagementedit",
        component: programManagementEdit,
      },
      {
        path: "/h&s",
        name: "HnS",
        component: HnS,
        children: [
          {
            path: "screening",
            name: "Screening",
            component: Screening,
          },
          {
            path: "interview",
            name: "Interview",
            component: Interview,
          },
          {
            path: "ov",
            name: "Ov",
            component: Ov,
          },
          {
            path: "prog_specs",
            name: "ProgSpecs",
            component: ProgSpecs,
          },
          {
            path: "job_offer",
            name: "JobOffer",
            component: JobOffer,
          },
        ],
      },
      {
        path: "/",
        component: OnboardingMainPageNew,
        meta: {
          requiresAuth: true,
          requiresRoles: ["onboarding","user"],
        },
        children: [
          {
            path: "/onboarding_list",
            name: "OnboardingFormNew",
            component: OnboardingFormNew,
          },
         
          {
            path: "onboarding_list/update/:id",
            name: "OnboardingUpdateForm",
            component: OnboardingUpdateForm,
            props: true,
          },
        ],
      },
      {
        path: "/",
        component: Onboarding,
        meta: {
          requiresAuth: true,
          requiresRoles: ["onboarding","user"],
        },
        children: [
          {
            path: "/onboarding_user_management",
            name: "UserSiteManagement",
            component: UserSiteManagement,
          },
          {
            path: "/onboarding_dashboard",
            name: "OnboardingForm",
            component: OnboardingForm,
          },
          

         
          {
            path: "onboarding_dashboard/employee_details/:id",
            name: "OnboardingEmployeeProfile",
            component: OnboardingEmployeeProfile,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/:id",
            name: "OnboardingUpdateSelection",
            component: OnboardingUpdateSelection,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/nbi/:id",
            name: "OnboardingNBI",
            component: OnboardingNBI,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/dt/:id",
            name: "OnboardingDT",
            component: OnboardingDT,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/peme/:id",
            name: "OnboardingPEME",
            component: OnboardingPEME,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/sss/:id",
            name: "OnboardingSSS",
            component: OnboardingSSS,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/workday/:id",
            name: "OnboardingWorkday",
            component: OnboardingWorkday,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/phic/:id",
            name: "OnboardingPHIC",
            component: OnboardingPHIC,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/pagibig/:id",
            name: "OnboardingPAGIBIG",
            component: OnboardingPAGIBIG,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/tin/:id",
            name: "OnboardingTIN",
            component: OnboardingTIN,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/health_certificate/:id",
            name: "OnboardingHEALTHCERTIFICATE",
            component: OnboardingHEALTHCERTIFICATE,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/occupational_permit/:id",
            name: "OnboardingOCCUPATIONALPERMIT",
            component: OnboardingOCCUPATIONALPERMIT,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/ofac/:id",
            name: "OnboardingOFAC",
            component: OnboardingOFAC,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/sam/:id",
            name: "OnboardingSAM",
            component: OnboardingSAM,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/oig/:id",
            name: "OnboardingOIG",
            component: OnboardingOIG,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/cibi/:id",
            name: "OnboardingCIBI",
            component: OnboardingCIBI,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/bgc/:id",
            name: "OnboardingBGC",
            component: OnboardingBGC,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/bc/:id",
            name: "OnboardingBIRTHCERTIFICATE",
            component: OnboardingBIRTHCERTIFICATE,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/mc/:id",
            name: "OnboardingMARRIAGECERTIFICATE",
            component: OnboardingMARRIAGECERTIFICATE,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/dbc/:id",
            name: "OnboardingDEPENDENTBIRTHCERTIFICATE",
            component: OnboardingDEPENDENTBIRTHCERTIFICATE,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/scholastic_record/:id",
            name: "OnboardingSCHOLASTIC",
            component: OnboardingSCHOLASTIC,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/previous_employment/:id",
            name: "OnboardingPREVIOUSEMPLOYMENT",
            component: OnboardingPREVIOUSEMPLOYMENT,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/supporting_document/:id",
            name: "OnboardingSUPPORTINGDOCUMENT",
            component: OnboardingSUPPORTINGDOCUMENT,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/lob/:id",
            name: "OnboardingLob",
            component: OnboardingLob,
            props: true,
          },
          {
            path: "onboarding_dashboard/update/selection/employee_info/:id",
            name: "OnboardingEmployeeInformation",
            component: OnboardingEmployeeInformation,
            props: true,
          },
        ],
      },
    ],
  },
  {
    path: "/",
    component: AppUserLayoutGuatemala,
    meta: {
      requiresAuth: true,
      requiresRoles: ["user", "remx", "sourcing", "budget"],
    },
    children: [
      {
        path: "/capfile/guatemala",
        name: "capacityFileReportGuatemala",
        component: capacityFileReportGuatemala,
        children: [
          {
            path: "history",
            name: "CapFileClassHistoryGuatemala",
            component: CapFileClassHistoryGuatemala,
          },
          {
            path: "summary",
            name: "CapFileHiringGuatemala",
            component: CapFileHiringGuatemala,
          },
          {
            path: "cancelled",
            name: "CapFileCancelledGuatemala",
            component: CapFileCancelledGuatemala,
          },
          {
            path: "moved",
            name: "CapFilePushedbackGuatemala",
            component: CapFilePushedbackGuatemala,
          },
          {
            path: "/capfileguatemala",
            name: "capacityFileGuatemala",
            component: capacityFileGuatemala,
          },
        ],
      },
      {
        path: "/pushbackcapfileguatemala/:id",
        name: "pushbackCapacityFileGuatemala",
        component: pushbackCapacityFileGuatemala,
      },
      {
        path: "/cancelcapfileguatemala/:id",
        name: "cancelCapacityFileGuatemala",
        component: cancelCapacityFileGuatemala,
      },
      {
        path: "/editcapfileguatemala/:id",
        name: "editCapFileGuatemala",
        component: editCapFileGuatemala,
      },
      {
        path: "/addcapfileguatemala/:id",
        name: "addCapacityFileGuatemala",
        component: addCapacityFileGuatemala,
      },
      {
        path: "/site_managementguatemala",
        name: "sitemanagementGuatemala",
        component: SiteManagementGuatemala,
      },
      {
        path: "/site_managementguatemala/edit/:id",
        name: "sitemanagementeditGuatemala",
        component: siteManagementEditGuatemala,
      },
      {
        path: "/program_managementguatemala",
        name: "programmanagementGuatemala",
        component: ProgramManagementGuatemala,
      },
      {
        path: "/program_managementguatemala/edit/:id",
        name: "programmanagementeditGuatemala",
        component: programManagementEditGuatemala,
      },
    ],
  },
  {
    path: "/",
    component: AppUserLayoutJamaica,
    meta: {
      requiresAuth: true,
      requiresRoles: ["user", "remx", "sourcing", "budget"],
    },
    children: [
      {
        path: "/capfile/jamaica",
        name: "capacityFileReportJamaica",
        component: capacityFileReportJamaica,
        children: [
          {
            path: "history",
            name: "CapFileClassHistoryJamaica",
            component: CapFileClassHistoryJamaica,
          },
          {
            path: "summary",
            name: "CapFileHiringJamaica",
            component: CapFileHiringJamaica,
          },
          {
            path: "cancelled",
            name: "CapFileCancelledJamaica",
            component: CapFileCancelledJamaica,
          },
          {
            path: "moved",
            name: "CapFilePushedbackJamaica",
            component: CapFilePushedbackJamaica,
          },
          {
            path: "/capfilejamaica",
            name: "capacityFileJamaica",
            component: capacityFileJamaica,
          },
        ],
      },
      {
        path: "/pushbackcapfilejamaica/:id",
        name: "pushbackCapacityFileJamaica",
        component: pushbackCapacityFileJamaica,
      },
      {
        path: "/cancelcapfilejamaica/:id",
        name: "cancelCapacityFileJamaica",
        component: cancelCapacityFileJamaica,
      },
      {
        path: "/editcapfilejamaica/:id",
        name: "editCapFileJamaica",
        component: editCapFileJamaica,
      },
      {
        path: "/addcapfilejamaica/:id",
        name: "addCapacityFileJamaica",
        component: addCapacityFileJamaica,
      },
      {
        path: "/site_managementjamaica",
        name: "sitemanagementJamaica",
        component: SiteManagementJamaica,
      },
      {
        path: "/site_managementjamaica/edit/:id",
        name: "sitemanagementeditJamaica",
        component: siteManagementEditJamaica,
      },
      {
        path: "/program_managementjamaica",
        name: "programmanagementJamaica",
        component: ProgramManagementJamaica,
      },
      {
        path: "/program_managementjamaica/edit/:id",
        name: "programmanagementeditJamaica",
        component: programManagementEditJamaica,
      },
    ],
  },
  {
    path: "/",
    component: AppAdminLayout,
    meta: {
      requiresAuth: true,
      requiresRoles: ["admin"],
    },
    children: [
      {
        path: "/admin_dashboard",
        name: "adminDashboard",
        component: AppAdminDashboard,
      },
    ],
  },


  {
    path: "/auth",
    name: "Auth",
    component: AuthLayout,
    meta: {
      isGuest: true,
    },
    children: [
      {
        path: "/login",
        name: "login",
        component: AppLogin,
      },
      {
        path: "/applicant_checker",
        name: "ApplicantChecker",
        component: ApplicantChecker,
      },
      {
        path: "/applicant_attendance/:id",
        name: "ApplicantAttendanceForm",
        component: ApplicantAttendanceForm,
      },
    ],
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth) {
    if (store.getters.isLoggedIn) {
      const requiredRoles = to.meta.requiresRoles || [];
      const userRole = store.getters.returnRole;

      if (requiredRoles.includes(userRole)) {
        next();
      } else {
        next({
          query: {
            returnUrl: to.path,
          },
        });
      }
    } else {
      next({
        name: "login",
      });
    }
  } else if (to.meta.isGuest && !store.getters.isLoggedIn) {
    next();
  } else {
    next();
  }
});

export default router;
