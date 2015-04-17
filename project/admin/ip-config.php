<?
$priorities = array(""=>"None", "P1"=>"P1", "P2"=>"P2", "P3"=>"P3", "P4"=>"P4", "P5"=>"P5");
$leadstatus = array("Open"=>"Open", "Intro"=>"Intro", "In-Progress"=>"In-Progress", "Agreement"=>"Agreement", "Rejected"=>"Rejected", "Completed"=>"Completed", "Closed"=>"Closed", "Future"=>"Future", "InvalidEmail"=>"InvalidEmail", "Delete"=>"Delete");
$referral = array(""=>"None", "Student"=>"Student", "Outsider"=>"Outsider", "Online"=>"Online", "Radio"=>"Radio", "University"=>"University", "Print"=>"Print");
$courses = array( "QA"=>"QA", "UI"=>"UI",".NET"=>".NET");
$candidateintent = array(""=>"None", "T&P"=>"T&P", "Training"=>"Training", "Placement"=>"Placement");
$workauthtype = array(""=>"None", "Citizen"=>"Citizen", "GC"=>"GC", "GC EAD"=>"GC EAD", "OPT"=>"OPT", "H1B"=>"H1B", "H4"=>"H4", "L1"=>"L1", "L2"=>"L2", "F1"=>"F1", "India"=>"India", "Non-US"=>"Non-US");
$subjectcategory = array("SQL"=>"SQL","Unix"=>"Unix","Web"=>"Web","WebServices"=>"Webservices","Testing"=>"Testing","Java"=>"Java","Selenium"=>"Selenium");

$candidatestatus = array("Active"=>"Active", "Discontinued"=>"Discontinued", "Break"=>"Break", "Marketing"=>"Marketing", "Placed"=>"Placed", "OnProject-Mkt"=>"OnProject-Mkt", "Completed"=>"Completed", "Defaulted"=>"Defaulted");
$progress = array(""=>"None", "Bad"=>"Bad", "OK"=>"OK", "Good"=>"Good", "Very Good"=>"Very Good");
$salary = array(""=>"None", "55K"=>"55K", "60K"=>"60K", "65K"=>"65K", "70K"=>"70K", "60%"=>"60%", "65%"=>"65%", "70%"=>"70%", "75%"=>"75%", "80%"=>"80%", "90%"=>"90%");
$sessionfeedback = array(""=>"None", "Cleared"=>"Cleared", "ReDo"=>"ReDo", "Start Studying"=>"Start Studying");
$sessionsubject = array(""=>"None", "SQL"=>"SQL", "UNIX"=>"UNIX", "Testing"=>"Testing", "Web + Services"=>"Web + Services", "Java"=>"Java", "Selenium"=>"Selenium", "JMeter"=>"JMeter", "Resume"=>"Resume", "Other"=>"Other");
$sessiontype = array(""=>"None", "Mock"=>"Mock", "Resume Session"=>"Resume Session", "Interview Prep"=>"Interview Prep", "Job Help"=>"Job Help", "Scenarios"=>"Scenarios", "Group Mock"=>"Group Mock", "Misc"=>"Misc");
$sessionstatus = array(""=>"None", "Scheduled"=>"Scheduled", "Candidate Cancelled"=>"Candidate Cancelled", "Instructor Cancelled"=>"Instructor Cancelled", "Completed"=>"Completed");
$marketingstatus = array("2-ToDo"=>"ToDo", "0-InProgress"=>"InProgress", "6-Suspended"=>"Suspended", "5-Closed"=>"Closed");
$paperwork = array(""=>"None", "Pending"=>"Pending", "Ignore"=>"Ignore", "Done"=>"Done");
$resumestatus = array("ToDo"=>"ToDo", "Ready"=>"Ready", "ReDo"=>"ReDo", "Reviewed"=>"Reviewed", "Approved"=>"Approved");
$technology = array("QA"=>"QA", ".NET"=>".NET", "Java QA"=>"Java QA", "J2EE"=>"J2EE");
$sessions = array("Not Needed"=>"Not Needed", "Avoiding"=>"Avoiding", "Not Attending"=>"Not Attending", "Attending"=>"Attending", "TimeWaste"=>"TimeWaste");
$suspensionreason = array("A"=>"Active","B"=>"Break" , "D"=>"Discontinued" ,"X"=>"Defaulted");
$recordingstatus = array("active"=>"active","inactive"=>"inactive","session"=>"session","internal"=>"internal","delete"=>"delete");
$emailengine=array("Gmail"=>"Gmail","PostageApp"=>"PostageApp");
//candidate prep and progress
$progresstype = array("Normal"=>"Normal", "FastTrack"=>"FastTrack", "Slow"=>"Slow", "No-Preparation"=>"No-Preparation");
$agreementtype = array("G"=>"General","C"=>"Candidate");

//interview
$interviewtype = array("Phone"=>"Phone", "F2F"=>"F2F", "Skype"=>"Skype", "Webinar"=>"Webinar");
$interviewdivision = array("AM"=>"AM", "PM"=>"PM");
$interviewhour = array("01"=>"01", "02"=>"02", "03"=>"03", "04"=>"04", "05"=>"05", "06"=>"06", "07"=>"07", "08"=>"08", "09"=>"09", "10"=>"10", "11"=>"11", "12"=>"12");
$interviewtime = array("00"=>"00", "15"=>"15", "30"=>"30", "45"=>"45");
$interviewstatus = array("Scheduled"=>"Scheduled", "Candidate Cancelled"=>"Candidate Cancelled", "Cancelled"=>"Cancelled", "Completed"=>"Completed", "Postponed"=>"Postponed");
$interviewresult = array(""=>"None", "Lost"=>"Lost", "No Response"=>"No Response", "Next Round"=>"Next Round", "Offer"=>"Offer", "Cancelled"=>"Cancelled");
$interviewperf = array(""=>"None", "Poor"=>"Poor", "Good"=>"Good", "Excellent"=>"Excellent");

//inside sales
$insidesaletype = array(""=>"None", "Reference"=>"Reference", "Proxy"=>"Proxy", "Special Class"=>"Special Class", "Scenarios"=>"Scenarios", "Feedback"=>"Feedback", "Notes"=>"Notes");
$insidesalestatus = array(""=>"None", "Open"=>"Open", "In Progress"=>"In Progress", "Not Responding"=>"Not Responding", "Not Interested"=>"Not Interested", "Closed"=>"Closed");

//vendors
$vendortier = array("1"=>"Prime", "2"=>"Level-2", "3"=>"Layers", "4"=>"Bad", "5"=>"Ugly");
$vendorstatus = array("Current"=>"Current", "Blacklisted"=>"Blacklisted", "RejectedUs"=>"RejectedUs", "Duplicate"=>"Duplicate");
$vendorlevel = array("0"=>"None", "1"=>"Superior", "2"=>"Excellent", "3"=>"Above average", "4"=>"Average", "5"=>"Below average");
$targetcompanytype = array("0"=>"None", "Client"=>"Client", "Vendor"=>"Vendor", "Implementor"=>"Implementor");
$vendormeetstatus = array(""=>"None", "MakingCalls"=>"MakingCalls", "Scheduled"=>"Scheduled", "Rejected"=>"Rejected", "Completed"=>"Completed", "Deferred"=>"Deferred");
$vendormeetfeedback = array(""=>"None", "Bad"=>"Bad", "OK"=>"OK", "Good"=>"Good", "Very Good"=>"Very Good");

//placements
$placementstatus = array(""=>"None", "0Active"=>"Active", "1NoTakeOff"=>"NoTakeOff", "2Completed"=>"Completed", "3Fired"=>"Fired", "4LaidOff"=>"LaidOff", "5Discontinued"=>"Discontinued", "6LayerChange"=>"LayerChange", "7Fulltime"=>"Fulltime");

//events
$eventstatus = array(""=>"None", "0Exploring"=>"Exploring", "1Discussions"=>"Discussions", "2Future"=>"Future", "3Rejected"=>"Rejected", "4Committed"=>"Committed");
$eventtype = array(""=>"None", "0DesiGathering"=>"DesiGathering", "1JobFair"=>"JobFair");
$eventfeedback = array(""=>"None", "0Good"=>"Good", "1NotWorth"=>"NotWorth", "2MustDo"=>"MustDo");

//recruit
$recruittype = array(""=>"None", "University"=>"University", "Individual"=>"Individual", "Event"=>"Event", "Social"=>"Social", "Restaurant"=>"Restaurant", "Group"=>"Group", "Store"=>"Store");
$recruitpriority = array(""=>"None", "P1"=>"P1", "P2"=>"P2", "P3"=>"P3", "P4"=>"P4", "P5"=>"P5");
$recruitstatus = array("Open"=>"Open", "In-Progress"=>"In-Progress", "Rejected"=>"Rejected", "Closed"=>"Closed", "Future"=>"Future");

//online recruitment
$onlinerecruittype = array(""=>"None", "Classified"=>"Classified", "Blog"=>"Blog", "Group"=>"Group", "Backlink"=>"Backlink", "DiscussionBoard"=>"DiscussionBoard");
$onlinerecruitstatus = array(""=>"None", "Active"=>"Active", "Pending"=>"Pending", "Rejected"=>"Rejected", "Expired"=>"Expired");
$onlinerecruitfeedback = array(""=>"None", "Excellent"=>"Excel", "Good"=>"Good", "OK"=>"OK", "Rejected"=>"Rejected");
$adtype = array(""=>"None", "WBQA"=>"WBQA", "MSNET"=>"MSNET", "IP"=>"IP", "COMBO"=>"COMBO");
$seotype = array(""=>"None", "DummyPage"=>"DummyPage", "Keywords"=>"Keywords", "Sitemap"=>"Sitemap");
$seostatus = array(""=>"None", "Active"=>"Active", "Expired"=>"Expired");

//references, proxies
$referencestatus = array(""=>"None", "0Active"=>"Active", "1NotInterested"=>"NotInterested", "2Suspended"=>"Suspended", "3NotWorking"=>"NotWorking", "4Discontinued"=>"Discontinued");
$communication = array(""=>"None", "Email"=>"Email", "Phone"=>"Phone", "WorkEmail"=>"WorkEmail");

//logins
$loginstatus = array(""=>"None", "Active"=>"Active", "InActive"=>"InActive", "Discontinued"=>"Discontinued");
$logintype = array(""=>"None", "Social"=>"Social", "Admin"=>"Admin", "Cloud"=>"Cloud", "FTP"=>"FTP", "MasterEmail"=>"MasterEmail", "External"=>"External", "TeamViewer"=>"TeamViewer", "HR"=>"HR");

//employees
$employeestatus = array(""=>"None", "0Active"=>"Active", "1Fired"=>"Fired", "2Discontinued"=>"Discontinued", "3Break"=>"Break");
$ptotype = array(""=>"None", "Extra"=>"Extra", "Sick"=>"Sick", "Vacation"=>"Vacation", "Forced"=>"Forced");

//machines and softwares
$machinetype = array(""=>"None", "Desktop"=>"Desktop", "Laptop"=>"Laptop", "Printer"=>"Printer");
$softwaretype = array(""=>"None", "Candidate"=>"Candidate", "Employee"=>"Employee", "Administrator"=>"Administrator");
$softwarestatus = array(""=>"None", "Active"=>"Active", "Inactive"=>"Inactive");

//ip emails
$ipemailstatus = array(""=>"None", "Created"=>"Created", "Candidate"=>"Candidate", "Disabled"=>"Disabled", "Lost"=>"Lost");
$ipphonestatus = array(""=>"None", "Active"=>"Active", "Inactive"=>"Inactive", "Lost"=>"Lost", "Released"=>"Released");

//tasks
$taskpriority = array(""=>"None", "Low"=>"Low", "Normal"=>"Normal", "High"=>"High");
$taskstatus = array("0Started"=>"Started", "2Pending"=>"Pending", "3Deferred"=>"Deferred", "4Complete"=>"Complete");
$taskpct = array("0%"=>"0%", "25%"=>"25%", "50%"=>"50%", "75%"=>"75%", "90%"=>"90%", "100%"=>"100%");

//general
$yesno = array("N"=>"N", "Y"=>"Y");
$culture = array("D"=>"Desi", "A"=>"American", "C"=>"Chinese", "R"=>"Russian", "E"=>"European");
$count = array("0"=>"0", "1"=>"1", "2"=>"2", "3"=>"3", "4"=>"4", "5"=>"5", "6"=>"6", "7"=>"7", "8"=>"8", "9"=>"9", "10"=>"10", 
			 	 "11"=>"11", "12"=>"12", "13"=>"13", "14"=>"14", "15"=>"15", "16"=>"16", "17"=>"17", "18"=>"18", "19"=>"19");
//teams
$completeteam = array(""=>"None", "Sudha"=>"Sudha", "Sampath"=>"Sampath", "Shilpi"=>"Shilpi", "Srinivas"=>"Srinivas", "Divya"=>"Divya", "Rasagna"=>"Rasagna", "Nikhil"=>"Nikhil", "Srividya"=>"Srividya", "Sandeep"=>"Sandeep", "Swati"=>"Swati", "Pooja"=>"Pooja", "Vinod"=>"Vinod", "Venkatesh"=>"Venkatesh", "Mahender"=>"Mahender", "Swetha"=>"Swetha", "Monica"=>"Monica");
$instructors = array(""=>"None", "Anitha"=>"Anitha", "Shilpi"=>"Shilpi", "Praveen"=>"Praveen", "Nisha"=>"Nisha", "Sampath"=>"Sampath");

//payments
$paymenttype = array("Payroll"=>"Payroll", "1099"=>"1099", "Cash"=>"Cash", "Invoice"=>"Invoice");
$invoicestatus = array("Open"=>"Open", "Closed"=>"Closed", "Void"=>"Void", "Delete"=>"Delete");
$loantype = array("Advance"=>"Advance", "Flight"=>"Flight", "Hotel"=>"Hotel", "Rent-Car"=>"Rent-Car");
$loanstatus = array("Open"=>"Open", "Overdue"=>"Overdue", "Closed"=>"Closed", "Default"=>"Default");

//questions
$questionscategory = array("QA-Must"=>"QA-Must", ""=>"None", "Analytical"=>"Analytical", "Vendor"=>"Vendor", "Coding"=>"Coding", "Java-Must"=>"Java-Must", ".NET-Must"=>".NET-Must");
$questionstype = array("Technical"=>"Technical", ""=>"None", "Management"=>"Management", "HR"=>"HR");
$questionssubject = array(""=>"None", "SQL"=>"SQL", "MongoDb"=>"MongoDb", "Testing"=>"Testing", "Java"=>"Java", "Web"=>"Web", "Services"=>"Services", "UNIX"=>"UNIX", "Automation"=>"Automation", "Performance"=>"Performance", "Selenium"=>"Selenium", "Unit Testing"=>"Unit Testing", "API"=>"API", "Mobile"=>"Mobile", "Javascript" => "Javascript");

$questionsrcategory = array("QA"=>"QA", "Analytical"=>"Analytical", "Coding"=>"Coding");
$questionsrsubject = array("SQL"=>"SQL", "Testing"=>"Testing", "Java"=>"Java", "Web"=>"Web", "Services"=>"Services", "UNIX"=>"UNIX", "Automation"=>"Automation", "Performance"=>"Performance", "Selenium"=>"Selenium", "Unit Testing"=>"Unit Testing", "API"=>"API");
$questionsrtype = array("Technical"=>"Technical", "Management"=>"Management");

$teams = array(""=>"None", "Recruiting"=>"Recruiting", "Marketing"=>"Marketing", "Training"=>"Training", "Sales"=>"Sales", "HR"=>"HR");
?>