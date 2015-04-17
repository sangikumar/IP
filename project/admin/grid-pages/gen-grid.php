<?php

$gridid = $_GET['id'];
if ($gridid == "AGREEMENT_MANAGEMENT") {
    $page_title = "Agreement Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/agreement.php";
}
if ($gridid == "SOFTWARE_MANAGEMENT") {
    $page_title = "Software Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/software.php";
}
if ($gridid == "CAN_ASSMT") {
    $page_title = "Candidate Assignment";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate_assignment.php";
}
if ($gridid == "CAN_UPDATED_PERSONAL_INFO") {
    $page_title = "Candidate Updated Personal Info";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate_updated_personal_info.php";
}
if ($gridid == "CAN_UPDATED_PLACEMENT_INFO") {
    $page_title = "Candidate Updated Placement Info";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate_updated_placement_info.php";
}
if ($gridid == "COURSE_MANAGEMENT") {
    $page_title = "Course Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/course.php";
} elseif ($gridid == "IP_APP_MANAGEMENT") {
    $page_title = "App Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ip_app.php";
} elseif ($gridid == "ACCESS_MANAGEMENT") {
    $page_title = "Access Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/access.php";
} elseif ($gridid == "ADSLOGIN_MANAGEMENT") {
    $page_title = "Ads Login Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/adslogins.php";
} elseif ($gridid == "ALLINTERVIEW_LIST") {
    $page_title = "All Interviews List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/allinterview.php";
} elseif ($gridid == "ALLRECRUITERS") {
    $page_title = "All Recruiters";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/allrecruiters.php";
} elseif ($gridid == "ASSET_MANAGEMENT") {
    $page_title = "Asset Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/asset.php";
} elseif ($gridid == "ASSIGNEMENT_MANAGEMENT") {
    $page_title = "Assignment Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/assignment.php";
} elseif ($gridid == "BATCH_MANAGEMENT") {
    $page_title = "Batch Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/batch.php";
} elseif ($gridid == "CAN_TEST_MANAGEMENT") {
    $page_title = "Test Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate_assignment.php";
} elseif ($gridid == "CAN_SESSIONS") {
    $page_title = "Sessions";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidatesessions.php";
} elseif ($gridid == "CAN_INTERVIEWS") {
    $page_title = "Interviews";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidateinterviews.php";
} elseif ($gridid == "CAN_POSITIONS") {
    $page_title = "Positions";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidatepositions.php";
} elseif ($gridid == "CAN_RECORDING_MANAGEMENT") {
    $page_title = "Candidate Recording Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/can_recording.php";
} elseif ($gridid == "CAN_RECORDING_MANAGEMENT") {
    $page_title = "Candidate Recording Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/can_recording.php";
} elseif ($gridid == "CAN_FAQ_MANAGEMENT") {
    $page_title = "Candidate FAQ Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate_faq.php";
} elseif ($gridid == "CAN_DEFAULT_MANAGEMENT") {
    $page_title = "Candidate Default Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidatedefault.php";
} elseif ($gridid == "CANDIDATE_LIST") {
    $page_title = "Candidate List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rmcandidate.php";
} elseif ($gridid == "RCANDIDATE_LIST") {
    $page_title = "Candidate List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rcandidate.php";
} elseif ($gridid == "CANDIDATE_MKTNG_MANAGEMENT") {
    $page_title = "Candidate Marketing Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidatemarketing.php";
} elseif ($gridid == "CANDIDATE_MANAGEMENT") {
    $page_title = "Candidate Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/candidate.php";
} elseif ($gridid == "CLIENT_LEADS_MANAGEMENT") {
    $page_title = "Client Leads Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/client_leads.php";
} elseif ($gridid == "CLIENT_MANAGEMENT") {
    $page_title = "Client Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/client.php";
} elseif ($gridid == "CLR_EMAIL_MANAGEMENT") {
    $page_title = "Crawler Email Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/clr_email.php";
} elseif ($gridid == "CMARKETING_MANAGEMENT") {
    $page_title = "Candidate Marketing Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rcmarketing.php";
} elseif ($gridid == "COLLECTION_AGENCY_MANAGEMENT") {
    $page_title = "Collection Agency Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/collectionagency.php";
} elseif ($gridid == "C_PMT_SETUP_MANAGEMENT") {
    $page_title = "Candidate Payment Setup Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/cpaymentsetup.php";
} elseif ($gridid == "CRASHER_MANAGEMENT") {
    $page_title = "Crasher Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/crasher.php";
} elseif ($gridid == "C_TIMESHEET_MANAGEMENT") {
    $page_title = "TimeSheet Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ctimesheet.php";
} elseif ($gridid == "DOCUMENT_MANAGEMENT") {
    $page_title = "Document Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/document.php";
} elseif ($gridid == "EMAIL_GROUP_MANAGEMENT") {
    $page_title = "Email Group Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/email_group.php";
} elseif ($gridid == "EMAIL_EXTRACT_MANAGEMENT") {
    $page_title = "Email Extract Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/email_extract.php";
} elseif ($gridid == "EMP_LEAD_MANAGEMENT") {
    $page_title = "Employee Lead Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/emp_lead.php";
} elseif ($gridid == "EMP_REC_MANAGEMENT") {
    $page_title = "Employee Recording Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/emp_recording.php";
} elseif ($gridid == "EMP_LIST") {
    $page_title = "Employee List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/remployee.php";
} elseif ($gridid == "EMP_MANAGEMENT") {
    $page_title = "Employee Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/employee.php";
} elseif ($gridid == "EMP_MACHINE_MANAGEMENT") {
    $page_title = "Employee Machine Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/empmachine.php";
} elseif ($gridid == "EMP_TIMESHEET_MANAGEMENT") {
    $page_title = "Employee Timesheet Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/emptimesheet.php";
} elseif ($gridid == "EVENT_MANAGEMENT") {
    $page_title = "Event Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/event.php";
} elseif ($gridid == "FAKE_REVIEW_MANAGEMENT") {
    $page_title = "Fake Review Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/fakereview.php";
} elseif ($gridid == "FEEDBACK_MANAGEMENT") {
    $page_title = "Feedback Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/feedback.php";
} elseif ($gridid == "FOLLOWUP_MANAGEMENT") {
    $page_title = "Follow up Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/followup.php";
} elseif ($gridid == "GOAL_LIST") {
    $page_title = "Goal List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rgoal.php";
} elseif ($gridid == "GOAL_MANAGEMENT") {
    $page_title = "Goal Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/goal.php";
} elseif ($gridid == "HOLIDAY_MANAGEMENT") {
    $page_title = "Holiday Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/holiday.php";
} elseif ($gridid == "INACTIVE_LOGIN_MANAGEMENT") {
    $page_title = "Inactive Login Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/inactivelogin.php";
} elseif ($gridid == "INSIDE_SALES_MANAGEMENT") {
    $page_title = "Inside Sales Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/insidesales.php";
} elseif ($gridid == "INSURANCE_MANAGEMENT") {
    $page_title = "Insurance Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/insurance.php";
} elseif ($gridid == "INSUR_DETAIL_MANAGEMENT") {
    $page_title = "Insurance Details Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/insurdetail.php";
} elseif ($gridid == "INTERVIEW_LIST") {
    $page_title = "Interview List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rinterview.php";
} elseif ($gridid == "INTERVIEW_MANAGEMENT") {
    $page_title = "Interview Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/interview.php";
} elseif ($gridid == "INVITATION_LIST") {
    $page_title = "Invitation List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/invitation.php";
} elseif ($gridid == "INVOICE_BYMONTH_MANAGEMENT") {
    $page_title = "Invoice By Month Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/invoicebymonth.php";
} elseif ($gridid == "INVOICE_MANAGEMENT") {
    $page_title = "Invoice Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/invoice.php";
} elseif ($gridid == "INVOICE_OVERDUE_MANAGEMENT") {
    $page_title = "Invoice Overdue Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/invoiceoverdue.php";
} elseif ($gridid == "IP_JOBTYPE_MANAGEMENT") {
    $page_title = "Job Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ip_jobtype.php";
} elseif ($gridid == "IP_NOTIFICATION_MANAGEMENT") {
    $page_title = "Notification Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ip_notification.php";
} elseif ($gridid == "IP_NOTIFICATION_QUEUE_MANAGEMENT") {
    $page_title = "Notification Queue Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ip_notification_queue.php";
} elseif ($gridid == "IP_EMAIL_MANAGEMENT") {
    $page_title = "IP Email Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/ipemail.php";
} elseif ($gridid == "ISSUE_MANAGEMENT") {
    $page_title = "Issue Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/issue.php";
} elseif ($gridid == "JOBHELP_LIST") {
    $page_title = "Job Help List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/jobhelp.php";
} elseif ($gridid == "JOB_TABLE") {
    $page_title = "JOB TABLE";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/clr_job.php";
} elseif ($gridid == "JOB_POSITION_IDS") {
    $page_title = "JOB POSITION";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/clr_position.php";
} elseif ($gridid == "JOB_APPLICATION_IDS") {
    $page_title = "JOB APPLICATIONS";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/clr_application.php";
} elseif ($gridid == "LAB_MANAGEMENT") {
    $page_title = "Lab Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/lab.php";
} elseif ($gridid == "LEAD_MANAGEMENT") {
    $page_title = "Lead Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/leads.php";
} elseif ($gridid == "LOAN_MANAGEMENT") {
    $page_title = "Loan Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/loan.php";
} elseif ($gridid == "LOGIN_HISTORY_MANAGEMENT") {
    $page_title = "Login History Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/loginhistory.php";
} elseif ($gridid == "LOGIN_LIST") {
    $page_title = "Login List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rlogins.php";
} elseif ($gridid == "LOGINS_MANAGEMENT") {
    $page_title = "Logins Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/logins.php";
} elseif ($gridid == "MASS_EMAIL_MANAGEMENT") {
    $page_title = "Mass Email Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/massemail.php";
} elseif ($gridid == "MASS_EMAIL_RUN_MANAGEMENT") {
    $page_title = "Mass Email Run Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/massemailrun.php";
} elseif ($gridid == "MKT_SUBSCRIPTION_MANAGEMENT") {
    $page_title = "Marketing Subscription Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/mkt-subscription.php";
} elseif ($gridid == "NEWS_MANAGEMENT") {
    $page_title = "News Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/news.php";
} elseif ($gridid == "NEW_VENDOR_EMAIL_MANAGEMENT") {
    $page_title = "New Vendor Email Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/newvendoremail.php";
} elseif ($gridid == "ONLINE_RECRUIT_MANAGEMENT") {
    $page_title = "Online Recruit Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/onlinerecruit.php";
} elseif ($gridid == "ORIENTATION_LIST") {
    $page_title = "Orientation List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/orientation.php";
} elseif ($gridid == "PAYMENT_MANAGEMENT") {
    $page_title = "Payment Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/payment.php";
} elseif ($gridid == "PLACEMENT_LIST") {
    $page_title = "Placement List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rplacement.php";
} elseif ($gridid == "PLACEMENT_MANAGEMENT") {
    $page_title = "Placement Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/placement.php";
} elseif ($gridid == "PO_MANAGEMENT") {
    $page_title = "PO Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/po.php";
} elseif ($gridid == "POSITION_LIST") {
    $page_title = "Position List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rposition.php";
} elseif ($gridid == "POSITION_MANAGEMENT") {
    $page_title = "Position Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/position.php";
} elseif ($gridid == "POSITION_CALL_LIST") {
    $page_title = "Position Call List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/positioncallr.php";
} elseif ($gridid == "POSITION_CALL_MANAGEMENT") {
    $page_title = "Position Call Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/positioncall.php";
} elseif ($gridid == "PROXY_MANAGEMENT") {
    $page_title = "Proxy Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/proxy.php";
} elseif ($gridid == "PTO_MANAGEMENT") {
    $page_title = "PTO Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/pto.php";
} elseif ($gridid == "PTO_LIST") {
    $page_title = "PTO List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rpto.php";
} elseif ($gridid == "QUESTION_LIST") {
    $page_title = "Question List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/questionr.php";
} elseif ($gridid == "QUESTION_MANAGEMENT") {
    $page_title = "Question Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/question.php";
} elseif ($gridid == "QUESTION_MANAGEMENT") {
    $page_title = "Question Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/question.php";
} elseif ($gridid == "REC_CRAWLER_MANAGEMENT") {
    $page_title = "Recruiting Crawler Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rec_crawler.php";
} elseif ($gridid == "REC_MASSEMAIL_MANAGEMENT") {
    $page_title = "Recruiting MassEmail Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rec_massemail.php";
} elseif ($gridid == "RECORDING_MANAGEMENT") {
    $page_title = "Recording Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/recording.php";
} elseif ($gridid == "RECRUITER_MANAGEMENT") {
    $page_title = "Recruiter Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/recruiter.php";
} elseif ($gridid == "RECRUITING_MANAGEMENT") {
    $page_title = "Recruiting Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/recruiting.php";
} elseif ($gridid == "REFERENCE_MANAGEMENT") {
    $page_title = "Reference Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/reference.php";
} elseif ($gridid == "R_EMPTIMESHEET_MANAGEMENT") {
    $page_title = "Employee Sheet Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/remptimesheet.php";
} elseif ($gridid == "R_SESSION_MANAGEMENT") {
    $page_title = "Session Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rsession.php";
} elseif ($gridid == "SALE_CALL_MANAGEMENT") {
    $page_title = "Sale Call Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/salecall.php";
} elseif ($gridid == "SALE_MEET_MANAGEMENT") {
    $page_title = "Sale Meet Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/salemeet.php";
} elseif ($gridid == "SEO_MANAGEMENT") {
    $page_title = "SEO Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/seo.php";
} elseif ($gridid == "SESSION_MANAGEMENT") {
    $page_title = "Session Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/session.php";
} elseif ($gridid == "SOFTWARE_MANAGEMENT") {
    $page_title = "Software Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/software.php";

} elseif ($gridid == "SUBMISSION_LIST") {
    $page_title = "Submission List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rsubmission.php";
} elseif ($gridid == "SUBMISSION_MANAGEMENT") {
    $page_title = "Submission Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/submission.php";
} elseif ($gridid == "VENDOR_URL_MANAGEMENT") {
    $page_title = "Vendor Url Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/vendor_url.php";
} elseif ($gridid == "VENDOR_LIST") {
    $page_title = "Vendor List";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/rvendor.php";
} elseif ($gridid == "VENDOR_MANAGEMENT") {
    $page_title = "Vendor Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/vendor.php";
} elseif ($gridid == "YELP_MANAGEMENT") {
    $page_title = "Yelp Management";
    $page_grid = $_SERVER["DOCUMENT_ROOT"] . "/project/admin/grids/yelpsettings.php";
}
require_once($_SERVER["DOCUMENT_ROOT"]."/ip-includes/gridheader.php");
?>