<?php
$root = 'http://' . $_SERVER["SERVER_NAME"];
$root = "$root/project/admin";
if (isUserLoggedIn()) {

    $userid = $loggedInUser->user_id;
    $candidateid = $loggedInUser->candidateid;
    $displayname = $loggedInUser->displayname;
    $username = $displayname;
    $connection = mysql_connect($db_host, $db_user, $db_pass);
    $SelectedDB = mysql_select_db($db_name);
    $result = mysql_query("SELECT c.id, c.mgrid FROM employee c where loginid = $userid");
    if ($userid) {
        $row = mysql_fetch_row($result);
        $employeeid = $row[0];
        $mgrid = $row[1];
    }
    mysql_close($connection);

    echo "
	<ul id='mymenu'>
	<li><a href='$root/account.php'>Home</a></li>
	<li><a href='$root/user_settings.php'>Settings</a></li>
	<li style='background-color: #cccccc;'><a href='$root/logout.php'>Logout</a></li>
	";
    if ($loggedInUser->checkPermission(array(2))) {
        echo "
        <li><a href='#'>Admin</a>
            <ul style='z-index: 1000;'>
                <li><a href='$root/ipadmin/admin_configuration.php'>Configuration</a></li>
                <li><a href='$root/ipadmin/admin_users.php'>Users</a></li>
                <li><a href='$root/ipadmin/admin_permissions.php'>Permissions</a></li>
                <li><a href='$root/ipadmin/admin_pages.php'>Pages</a></li>
            </ul>
        </li>
        <li><a href='#'>Employee</a>
            <ul style='z-index: 1000;'>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMP_MANAGEMENT'>List</a></li>
                <li><a href='#'>Time</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT'>PTO</a></li>
												<li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT&type=total'>PTO Total</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMP_TIMESHEET_MANAGEMENT'>Timesheets</a></li>
                    </ul>
                </li>
                <li><a href='#'>Mgmt</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMP_REC_MANAGEMENT'>Recordings</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Machines</a></li>
                    </ul>
                </li>
                <li><a href='#'>Training</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
                        <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>
                    </ul>
                </li>
                <li><a href='#'>Hiring</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMP_LEAD_MANAGEMENT'>Leads</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Recruiting</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Leads</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=LEAD_MANAGEMENT'>Lead</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=RECRUITING_MANAGEMENT'>Dice</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ACCESS_MANAGEMENT'>Access</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INACTIVE_LOGIN_MANAGEMENT'>Invalids</a></li>
                        <li><a href='$root/ipadmin/resume-uploads.php'>Resumes</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CAN_FAQ_MANAGEMENT'>FAQ</a></li>
                    </ul>
                </li>
                <li><a href='#'>Enrollment</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=BATCH_MANAGEMENT'>Batch</a></li>
                        <li><a href='#'>Candidates</a>
                            <ul style='z-index: 1000;'>
                                <li><a href='$root/grid-pages/gen-grid.php?id=CANDIDATE_MANAGEMENT'>List</a></li>
                                <li><a href='$root/search-pages/candidate-search.php'>Search</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href='#'>Online</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ONLINE_RECRUIT_MANAGEMENT'>Ad Posting</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ADSLOGIN_MANAGEMENT'>Ads Logins</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=FAKE_REVIEW_MANAGEMENT'>Fake Reviews</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=YELP_MANAGEMENT'>Yelp Settings</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SEO_MANAGEMENT'>SEO</a></li>
                    </ul>
                </li>
                <li><a href='#'>Events</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EVENT_MANAGEMENT'>Events</a></li>
                    </ul>
                </li>
                <li><a href='#'>Crawl</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=REC_CRAWLER_MANAGEMENT'>Sites</a></li>
												<li><a href='$root/grid-pages/gen-grid.php?id=REC_MASSEMAIL_MANAGEMENT'>DB</a></li>
                    </ul>
                </li>								
                <li><a href='#'>Inside Sales</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INSIDE_SALES_MANAGEMENT'>Inside Sales</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=FOLLOWUP_MANAGEMENT'>Follow up</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=REFERENCE_MANAGEMENT'>Reference</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=FEEDBACK_MANAGEMENT'>Feedback</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=NEWS_MANAGEMENT'>News</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Training</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Classes</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SESSION_MANAGEMENT'>Sessions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ASSIGNEMENT_MANAGEMENT'>Assignments</a></li>
                        <li><a href='$root/search-pages/notesmgmt.php'>Notes</a></li>
                    </ul>
                </li>
                <li><a href='#'>Questions</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=QUESTION_MANAGEMENT'>Q Mgmt</a></li>
                        <li><a href='$root/search-pages/questions-search.php'>Search</a></li>
                    </ul>
                </li>
                <li><a href='#'>Recordings</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Classes</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CAN_RECORDING_MANAGEMENT'>Candidate</a></li>
                    </ul>
                </li>
                <li><a href='#'>Resume</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>
                       
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Marketing</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Marketing</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CANDIDATE_MKTNG_MANAGEMENT'>All</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Current</a></li>
                    </ul>
                </li>
                <li><a href='#'>Positions</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SUBMISSION_MANAGEMENT'>Submissions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=POSITION_MANAGEMENT'>Positions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_LIST'>Calls</a></li>
                    </ul>
                </li>
                <li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interviews</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IP Emails</a></li>
            </ul>
        </li>
        <li><a href='#'>Sales</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Vendors</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
												<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
							</ul>
						</li>						
                    </ul>
                </li>
                <li><a href='#'>Clients</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/clientsearch.php'>Search</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=client'>By Client</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cplacement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=clist'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cwork'>Detailed</a></li>
							</ul>
						</li>						
                    </ul>
                </li>				
				<li><a href='#'>Recruiters</a>
					<ul style='z-index: 1000;'>
						<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
					</ul>
				</li>					
                <li><a href='#'>Sales</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_LEADS_MANAGEMENT'>Client Leads</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>
                    </ul>
                </li>
                <li><a href='#'>Placement</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placements</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CAN_UPDATED_PLACEMENT_INFO'>CUpdated Placement</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=AGREEMENT_MANAGEMENT'>Agreement</a></li>
                        <li><a href='$root/search-pages/projectfiles.php'>Project Files</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>HR</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Time</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PO_MANAGEMENT'>PO</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PO_MANAGEMENT'>MM PO</a></li>
                        <li><a href='#'>Timesheets</a>
                            <ul style='z-index: 1000;'>
                                <li><a href='$root/search-pages/candidatetimesheets.php'>Uploads</a></li>
                                <li><a href='$root/grid-pages/gen-grid.php?id=C_TIMESHEET_MANAGEMENT'>Grid</a></li>
                                <li><a href='$root/search-pages/timesheet-search.php'>Search</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href='#'>Invoice</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_OVERDUE_MANAGEMENT'>Overdue</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_MANAGEMENT'>By PO</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_BYMONTH_MANAGEMENT'>By Month</a></li>
                    </ul>
                </li>
                <li><a href='#'>Payment</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=C_PMT_SETUP_MANAGEMENT'>CPS</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=LOAN_MANAGEMENT'>Loans</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PAYMENT_MANAGEMENT'>Payments</a></li>
                    </ul>
                </li>
                <li><a href='#'>Expenses</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/invoicetodomgmt1.php'>Expenses</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_OVERDUE_MANAGEMENT'>Recurring</a></li>
                    </ul>
                </li>
                <li><a href='#'>Insurance</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INSURANCE_MANAGEMENT'>Total</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INSUR_DETAIL_MANAGEMENT'>Details</a></li>
                    </ul>
                </li>
                <li><a href='#'>Default</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=COLLECTION_AGENCY_MANAGEMENT'>Agencies</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CAN_DEFAULT_MANAGEMENT'>Cases List</a></li>
												<li><a href='$root/ajax-content/candidate-default.php'>Cases</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Company</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Infrastr</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=LAB_MANAGEMENT'>Lab</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SOFTWARE_MANAGEMENT'>Softwares</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=LOGINS_MANAGEMENT'>Logins</a></li>
                        <li><a href='http://indiavoyager.com/scans.php' target='_blank'>Scans</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>
                        <li><a href='#'>Email System</a>
                            <ul style='...'>
                                <li><a href='$root/search-pages/emailtemplatemgmt.php'>Email Templates</a></li>
                                <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_GROUP_MANAGEMENT'>Email Groups </a></li>
                                <li><a href='$root/search-pages/emailjobmgmt.php'>Send Email</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href='$root/grid-pages/gen-grid.php?id=HOLIDAY_MANAGEMENT'>Holidays</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=ASSET_MANAGEMENT'>Assets</a></li>
                <li><a href='$root/grid-pages/taskmgmt.php'>Setup</a></li>	
								<li><a href='$root/ipadmin/admin_pages.php'>Taxes</a></li>							
            </ul>
        </li>
        <li><a href='#'>Tools</a>
            <ul style='z-index: 1000;'>
				        <li><a href='#'>Apps</a>
                    <ul style='z-index: 1000;'>
						           <li><a href='$root/grid-pages/gen-grid.php?id=IP_APP_MANAGEMENT'>List</a></li>
                    </ul>
                </li>
                <li><a href='#'>Crawler</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_TABLE'>Jobs</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_POSITION_IDS'>Positions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_APPLICATION_IDS'>Applications</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
                    </ul>
                </li>
                <li><a href='#'>Email</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLR_EMAIL_MANAGEMENT'>List</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_EXTRACT_MANAGEMENT'>Extraction</a></li>
                    </ul>
                </li>
                <li><a href='#'>Appts & Backup</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=IP_JOBTYPE_MANAGEMENT&type=AB'>List</a></li> 
                    </ul>
                </li>
                <li><a href='#'>Jobs</a>
                    <ul style='z-index: 1000;'>
						            <li><a href='$root/grid-pages/gen-grid.php?id=IP_JOBTYPE_MANAGEMENT&type=N'>List</a></li>
			              </ul>
                </li>		
								<li><a href='#'>Notifications</a>
                    <ul style='z-index: 1000;'>
						            <li><a href='$root/grid-pages/gen-grid.php?id=IP_NOTIFICATION_MANAGEMENT'>List</a></li>
												<li><a href='$root/grid-pages/gen-grid.php?id=IP_NOTIFICATION_QUEUE_MANAGEMENT'>Queue</a></li>                        
                    </ul>
                </li>							
              	<li>
                	<a href='#'>Mass Emails</a>
                	<ul style='z-index: 1000;'>
                  	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Run</a></li>
                  	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
                	</ul>
              	</li>
				<li><a href='$root/grid-pages/gen-grid.php?id=CRASHER_MANAGEMENT'>Crasher</a></li>									
            </ul>
        </li>

        <li><a href='#'>Reports</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Lists</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='#'>Invitation</a>
                            <ul style='z-index: 1000;'>
                                <li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Class</a></li>
                                <li><a href='$root/grid-pages/gen-grid.php?id=JOBHELP_LIST'>Job Help</a></li>
                            </ul>
                        </li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ORIENTATION_LIST'>Orientation</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_HISTORY_MANAGEMENT'>Login History</a></li>
                    </ul>
                </li>
                <li><a href='$root/grid-pages/invoicetodomgmt1.php'>Candidate</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_OVERDUE_MANAGEMENT'>MM</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_OVERDUE_MANAGEMENT'>Placement</a></li>
            </ul>
        </li>
	";
    }
    //Links for permission level 3 (Manager)
    if ($loggedInUser->checkPermission(array(3))) {
        echo "
	<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employees</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT'>PTO</a></li>	
		<li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT&type=total'>PTO Total</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=EMP_TIMESHEET_MANAGEMENT'>Weekly</a></li>	
		<li><a href='$root/grid-pages/gen-grid.php?id=EMP_REC_MANAGEMENT'>Recordings</a></li>
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>
          <li><a href='$root/search-pages/htm_template.php'>Test  Template </a></li>
        </ul>
      </li>	
    	<li>
      <a href='#'>Hiring</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/grid-pages/gen-grid.php?id=EMP_LEAD_MANAGEMENT'>Leads</a></li>
        </ul>
      </li>					
    </ul>
  </li>			
		
  <li>
  <a href='#'>Lead</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LEAD_MANAGEMENT'>Leads</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=ACCESS_MANAGEMENT'>Access</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=INACTIVE_LOGIN_MANAGEMENT'>Invalids</a></li>
			<li><a href='$root/ipadmin/resume-uploads.php'>Resumes</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=CAN_FAQ_MANAGEMENT'>FAQ</a></li>
    </ul>
  </li>		
	
  <li><a href='#'>Crawl</a>
      <ul style='z-index: 1000;'>
        <li><a href='$root/grid-pages/gen-grid.php?id=REC_CRAWLER_MANAGEMENT'>Sites</a></li>
        <li><a href='$root/grid-pages/gen-grid.php?id=REC_MASSEMAIL_MANAGEMENT'>DB</a></li>
      </ul>
  </li>
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
	<li><a href='$root/grid-pages/gen-grid.php?id=BATCH_MANAGEMENT'>Batch</a></li>
	<li><a href='$root/grid-pages/gen-grid.php?id=COURSE_MANAGEMENT'>Course</a></li>
	<li><a href='$root/grid-pages/gen-grid.php?id=CAN_UPDATED_PERSONAL_INFO'>CPersonal Info</a></li>
	<li><a href='$root/grid-pages/gen-grid.php?id=CAN_UPDATED_PLACEMENT_INFO'>CPlacement Info</a></li>
    <li>
	<a href='#'>Candidates</a>
	<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>List</a></li>
		<li><a href='$root/search-pages/candidate-search.php'>Search</a></li>
	</ul>
	</li>	    	
    </ul>  
  </li>		

  <li>
  <a href='#'>Training</a>
    <ul style='z-index: 1000;'>
	<li><a href='$root/grid-pages/gen-grid.php?id=ASSIGNEMENT_MANAGEMENT'>Assignments</a></li>
	<li><a href='$root/search-pages/notesmgmt.php'>Notes</a></li>
	<li>
	<a href='#'>Questions</a>
		<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=QUESTION_MANAGEMENT'>Q Mgmt</a></li>		
		<li><a href='$root/search-pages/questions-search.php'>Search</a></li>
		</ul>
	</li>	
	<li><a href='$root/grid-pages/gen-grid.php?id=SESSION_MANAGEMENT'>Sessions</a></li>	
	<li>
	<a href='#'>Recordings</a>
		<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Classes</a></li>		
		<li><a href='$root/grid-pages/gen-grid.php?id=CAN_RECORDING_MANAGEMENT'>Candidate</a></li>	
		</ul>
	</li>	
	<li>
    <a href='#'>Resume</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>	
      <li><a href='$root/search-pages/resume-search.php'>Search</a></li>
    </ul>
  </li>   			 	
    </ul>
  </li>			
	
  <li>
  <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
	<li>
	<a href='#'>Positions</a>
	<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=SUBMISSION_MANAGEMENT'>Submissions</a></li>	
		<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_MANAGEMENT'>Positions</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_MANAGEMENT'>Calls</a></li>	
	</ul>
	</li>			
		<li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interview</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=MKT_SUBSCRIPTION_MANAGEMENT'>Subscriptions</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Mass Emails</a></li>
      <li>
      <a href='#'>MKT</a>
      <ul style='z-index: 1000;'>
      	<li><a href='$root/grid-pages/gen-grid.php?id=CANDIDATE_MKTNG_MANAGEMENT'>All</a></li>	
      	<li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Current</a></li>		
      </ul>
      </li>				
    </ul>
  </li>			
	
  <li>
  <a href='#'>Inside Sales</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=INSIDE_SALES_MANAGEMENT'>Inside Sales</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=FOLLOWUP_MANAGEMENT'>Follow up</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=REFERENCE_MANAGEMENT'>Reference</a></li>			
    	<li><a href='$root/grid-pages/gen-grid.php?id=FEEDBACK_MANAGEMENT'>Feedback</a></li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=NEWS_MANAGEMENT'>News</a></li>			
    </ul>
  </li>		
	
  <li>
  <a href='#'>Vendor</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>
			<li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
		<li><a href='#'>Recruiters</a>
			<ul style='z-index: 1000;'>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
			</ul>
		</li>				
    </ul>
  </li>			
	
  <li>
  <a href='#'>Recruiter</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
    </ul>
  </li>			
	
  <li>
  <a href='#'>Sales</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_LEADS_MANAGEMENT'>Client Leads</a></li>
		  <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>	
		  <li>
      <a href='#'>Emails DB</a>
      <ul style='z-index: 1000;'>
      	<li><a href='$root/grid-pages/gen-grid.php?id=NEW_VENDOR_EMAIL_MANAGEMENT'>Recent</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
      </ul>
      </li>								
    </ul>
  </li>		

  <li>
  <a href='#'>Placement</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_LIST'>Vendor</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=RECRUITER_MANAGEMENT'>Recruiter</a></li>	
      <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>Client</a></li>	
      <li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placement</a></li>		
			<li><a href='$root/search-pages/projectfiles.php'>Project Files</a></li> 	    	
    </ul>
  </li>		
	
  <li>
  <a href='#'>Recruiting</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EVENT_MANAGEMENT'>Event</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=RECRUITING_MANAGEMENT'>Recruiting</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=ONLINE_RECRUIT_MANAGEMENT'>Ad Posting</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=ADSLOGIN_MANAGEMENT'>Ads Logins</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=FAKE_REVIEW_MANAGEMENT'>Fake Reviews</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=YELP_MANAGEMENT'>Yelp Settings</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=SEO_MANAGEMENT'>SEO</a></li>	   	
    </ul>
  </li>	
<li><a href='#'>Tools</a>
            <ul style='z-index: 1000;'>
				        <li><a href='#'>Apps</a>
                    <ul style='z-index: 1000;'>
						           <li><a href='$root/grid-pages/gen-grid.php?id=IP_APP_MANAGEMENT'>List</a></li>
                    </ul>
                </li>
                <li><a href='#'>Crawler</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_TABLE'>Jobs</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_POSITION_IDS'>Positions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_APPLICATION_IDS'>Applications</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
                    </ul>
                </li>
                <li><a href='#'>Email</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLR_EMAIL_MANAGEMENT'>List</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_EXTRACT_MANAGEMENT'>Extraction</a></li>
                    </ul>
                </li>
                <li><a href='#'>Appts & Backup</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=IP_JOBTYPE_MANAGEMENT&type=AB'>List</a></li> 
                    </ul>
                </li>
                <li><a href='#'>Jobs</a>
                    <ul style='z-index: 1000;'>
						            <li><a href='$root/grid-pages/gen-grid.php?id=IP_JOBTYPE_MANAGEMENT&type=N'>List</a></li>
	                  </ul>
                </li>	
								<li><a href='#'>Notifications</a>
                    <ul style='z-index: 1000;'>
						            <li><a href='$root/grid-pages/gen-grid.php?id=IP_NOTIFICATION_MANAGEMENT'>List</a></li>
												<li><a href='$root/grid-pages/gen-grid.php?id=IP_NOTIFICATION_QUEUE_MANAGEMENT'>Queue</a></li>                        
                    </ul>
                </li>								
              	<li>
                	<a href='#'>Mass Emails</a>
                	<ul style='z-index: 1000;'>
                  	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Run</a></li>
                  	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
                	</ul>
              	</li>
				<li><a href='$root/grid-pages/gen-grid.php?id=CRASHER_MANAGEMENT'>Crasher</a></li>									
            </ul>
        </li>
        
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LAB_MANAGEMENT'>Lab</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Recordings</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Emp Machines</a></li>	
            <li><a href='$root/grid-pages/gen-grid.php?id=SOFTWARE_MANAGEMENT'>Software</a></li>
            <li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IPEmail</a></li>
            <li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>
		    <li><a href='http://indiavoyager.com/scans.php' target='_blank'>Scans</a></li>
            <li><a href='#'>Email System</a>
            <ul style='...'>
                <li><a href='$root/search-pages/emailtemplatemgmt.php'>Email Templates</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_GROUP_MANAGEMENT'>Email Groups </a></li>
                <li><a href='$root/search-pages/emailjobmgmt.php'>Send Email</a></li>
            </ul>
            </li>

    </ul>
  </li>			
	
	<li>
  <a href='#'>Company</a>
    <ul style='z-index: 1000;'>
    	<li>
      <a href='#'>Insurance</a>
        <ul style='z-index: 1000;'>
    		  <li><a href='$root/grid-pages/gen-grid.php?id=INSURANCE_MANAGEMENT'>Total</a></li>
					<li><a href='$root/grid-pages/gen-grid.php?id=INSUR_DETAIL_MANAGEMENT'>Details</a></li>
        </ul>
      </li>				
    </ul>
  </li>			
  <li>
  <a href='#'>Lists</a>
    <ul style='z-index: 1000;'>
    	<li>
      <a href='#'>Invitation</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Class</a></li>		
    			<li><a href='$root/grid-pages/gen-grid.php?id=JOBHELP_LIST'>Job Help</a></li>
        </ul>
      </li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=ORIENTATION_LIST'>Orientation</a></li>	 
			<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_HISTORY_MANAGEMENT'>Login History</a></li> 	
    </ul>
  </li>			
	";
    }

    //Links for permission level 4 (Marketing Manager)
    if ($loggedInUser->checkPermission(array(4))) {
        echo "
        <li><a href='#'>Employee</a>
            <ul style='z-index: 1000;'>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>List</a></li>
                <li><a href='#'>Time</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>
                            PTO</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>
                            Timesheets</a></li>
                    </ul>
                </li>
                <li><a href='#'>Training</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
                        <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>
                    </ul>
                </li>
                <li><a href='#'>Mgmt</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Machines</a></li>
                    </ul>
                </li>								
            </ul>
        </li>

        <li><a href='#'>Recruiting</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Leads</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=RECRUITING_MANAGEMENT'>Dice</a></li>
                        <li><a href='$root/ipadmin/resume-uploads.php'>Resumes</a></li>
                    </ul>
                </li>
                <li><a href='#'>Enrollment</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='#'>Candidates</a>
                            <ul style='z-index: 1000;'>
                                <li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>List</a></li>
                                <li><a href='$root/search-pages/candidate-search.php'>Search</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Training</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Resume</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>
                        <li><a href='$root/search-pages/resume-search.php'>Search</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Marketing</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Marketing</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Current</a></li>
                    </ul>
                </li>
                <li><a href='#'>Positions</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SUBMISSION_MANAGEMENT'>Submissions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=POSITION_MANAGEMENT'>Positions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_MANAGEMENT'>Calls</a></li>
                    </ul>
                </li>
                <li><a href='#'>Interviews</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_LIST&employeeid=$employeeid&userid=$userid'>Mine</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=ALLINTERVIEW_LIST'>All</a></li>
                    </ul>
                </li>
                <li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IP Emails</a></li>
            </ul>
        </li>
        <li><a href='#'>Sales</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Vendors</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
						<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
							</ul>
						</li>	
                    </ul>
                </li>
                <li><a href='#'>Clients</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/clientsearch.php'>Search</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=client'>By Client</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cplacement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=clist'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cwork'>Detailed</a></li>
							</ul>
						</li>						
                    </ul>
                </li>				
                <li><a href='#'>Recruiters</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
                    </ul>
                </li>
                <li><a href='#'>Placement</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>Clients</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placements</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=AGREEMENT_MANAGEMENT'>Agreement</a></li>
                    </ul>
                  </li>


                    </ul>
                </li>
            </ul>
        </li>
        <li><a href='#'>Tools</a>
            <ul style='z-index: 1000;'>
                <li><a href='#'>Mass Emails</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Run</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>
						<li><a href='$root/grid-pages/gen-grid.php?id=IP_APP_MANAGEMENT'>Apps</a></li>
                    </ul>
                </li>
                <li><a href='#'>Crawler</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_TABLE'>Jobs</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_POSITION_IDS'>Positions</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=JOB_APPLICATION_IDS'>Applications</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
                    </ul>
                </li>
                <li><a href='#'>Email</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLR_EMAIL_MANAGEMENT'>List</a></li>
                        <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_EXTRACT_MANAGEMENT'>Extraction</a></li>
                    </ul>
                </li>
            </ul>
        </li>";
    }

    //Links for permission level 5 (Batch Manager)
    if ($loggedInUser->checkPermission(array(5))) {
        echo "
	<li><a href='$root/grid-pages/goallist.php?employeeid=$employeeid&status=0Started'>Goals</a></li>			
	<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employee</a></li>			
    	<li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>PTO</a></li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>	
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>	
    </ul>
  </li>				
	
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
	<li><a href='$root/grid-pages/gen-grid.php?id=BATCH_MANAGEMENT'>Batch</a></li>
	<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>
    </ul>
  </li>		

  <li>
  <a href='#'>Training</a>
    <ul style='z-index: 1000;'>
	<li><a href='$root/grid-pages/gen-grid.php?id=ASSIGNEMENT_MANAGEMENT'>Assignments</a></li>
	<li><a href='$root/search-pages/notesmgmt.php'>Notes</a></li>
	<li>
	<a href='#'>Questions</a>
		<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=QUESTION_MANAGEMENT'>Q Mgmt</a></li>		
		<li><a href='$root/search-pages/questions-search.php'>Search</a></li>
		</ul>
	</li>	
	<li><a href='$root/grid-pages/gen-grid.php?id=SESSION_MANAGEMENT'>Sessions</a></li>	
	<li>
	<a href='#'>Recordings</a>
		<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Classes</a></li>		
		<li><a href='$root/grid-pages/gen-grid.php?id=CAN_RECORDING_MANAGEMENT'>Candidate</a></li>	
		</ul>
	</li>	
		<li>
    <a href='#'>Resume</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>	
      <li><a href='$root/search-pages/resume-search.php'>Search</a></li>
    </ul>
  </li>    			 	
    </ul>
  </li>			
	
  <li>
  <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interviews</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>List</a></li>			
    </ul>
  </li>			
	
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li> 	
			<li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Recordings</a></li>	
			
    </ul>
  </li>				
		
  <li>
  <a href='#'>Lists</a>
    <ul style='z-index: 1000;'>
    	<li>
      <a href='#'>Invitation</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Class</a></li>		
    			<li><a href='$root/grid-pages/gen-grid.php?id=JOBHELP_LIST'>Job Help</a></li>
        </ul>
      </li>
    </ul>
  </li>";
    }

    //Links for permission level 6 (Instructor)
    if ($loggedInUser->checkPermission(array(6))) {
        echo "
	
  <li>
  <a href='#'>Preparation</a>
    <ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=R_SESSION_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Sessions</a></li>	
    <li>
    <a href='#'>Questions</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=QUESTION_LIST'>Q Mgmt</a></li>		
    	<li><a href='$root/search-pages/questions-search.php'>Search</a></li>
    </ul>
    </li>		
    </ul>
  </li>		

  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>
    </ul>
  </li>	  
	
  <li>
  <a href='#'>Lists</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Invitation</a></li>
    </ul>
  </li>";
    }

    //Links for permission level 7 (vendor Manager)
    if ($loggedInUser->checkPermission(array(7))) {
        echo "
	
	<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employee</a></li>			
    	<li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>PTO</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>	
    </ul>
  </li>		
	
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>
    </ul>
  </li>	
			
  <li>
  <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=POSITION_MANAGEMENT'>Position</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_LIST'>Calls</a></li>			
      <li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interview</a></li>	
      <li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Marketing</a></li>		
    </ul>
  </li>			
	
  <li>
  <a href='#'>Vendor</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>
			<li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
			<li><a href='#'>Recruiters</a>
				<ul style='z-index: 1000;'>
					<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
					<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
				</ul>
			</li>	
    </ul>
  </li>			
	
  <li>
  <a href='#'>Recruiter</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
    </ul>
  </li>			
	
  <li>
  <a href='#'>Sales</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_LEADS_MANAGEMENT'>Client Leads</a></li>
		  <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>	
		  <li>
      <a href='#'>Emails DB</a>
      <ul style='z-index: 1000;'>
      	<li><a href='$root/grid-pages/gen-grid.php?id=NEW_VENDOR_EMAIL_MANAGEMENT'>Recent</a></li>
		    <li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
      </ul>
      </li>		
			<li>
    	<a href='#'>Mass Emails</a>
    	<ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Run</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
    	</ul>
    	</li>							
    </ul>
  </li>			

  <li>
  <a href='#'>Placement</a>
    <ul style='z-index: 1000;'>
    <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>Client</a></li>
    <li><a href='$root/grid-pages/gen-grid.php?id=AGREEMENT_MANAGEMENT'>Agreement</a></li>
  	<li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placement</a></li>
    </ul>
  </li>		
	
  <li>
  <a href='#'>Tools</a>
	<ul style='z-index: 1000;'>
        <li><a href='#'>Crawler</a>
            <ul style='z-index: 1000;'>
                <li><a href='$root/grid-pages/gen-grid.php?id=JOB_TABLE'>Jobs</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=JOB_POSITION_IDS'>Positions</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=JOB_APPLICATION_IDS'>Applications</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
            </ul>
        </li>
        <li><a href='#'>Email</a>
            <ul style='z-index: 1000;'>
                <li><a href='$root/grid-pages/gen-grid.php?id=CLR_EMAIL_MANAGEMENT'>List</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_EXTRACT_MANAGEMENT'>Extraction</a></li>
            </ul>
        </li>
	</ul>
  </li>	

  <li>
  <a href='#'>InfraStr</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>
    	<li><a href='#'>Email System</a>
            <ul style='...'>
                <li><a href='$root/search-pages/emailtemplatemgmt.php'>Email Templates</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_GROUP_MANAGEMENT'>Email Groups </a></li>
                <li><a href='$root/search-pages/emailjobmgmt.php'>Send Email</a></li>
            </ul>
        </li>
    </ul>
  </li>";
    }

    //Links for permission level 9 (Recruiter)
    if ($loggedInUser->checkPermission(array(9))) {
        echo "
		
<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employee</a></li>			
			<li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>PTO</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>		
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>	
    </ul>
  </li>				
  <li>
  <a href='#'>Lead</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LEAD_MANAGEMENT'>Lead</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=ACCESS_MANAGEMENT'>Access</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=INACTIVE_LOGIN_MANAGEMENT'>Invalids</a></li>
			<li><a href='$root/ipadmin/resume-uploads.php'>Resumes</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=CAN_FAQ_MANAGEMENT'>FAQ</a></li>
    </ul>
  </li>		
	
  <li><a href='#'>Crawl</a>
      <ul style='z-index: 1000;'>
          <li><a href='$root/grid-pages/gen-grid.php?id=REC_CRAWLER_MANAGEMENT'>Sites</a></li>
					<li><a href='$root/grid-pages/gen-grid.php?id=REC_MASSEMAIL_MANAGEMENT'>DB</a></li>
      </ul>
  </li>	
	
 <li>
  <a href='#'>Recruiting</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=EVENT_MANAGEMENT'>Event</a></li>			
      <li><a href='$root/grid-pages/gen-grid.php?id=RECRUITING_MANAGEMENT'>Recruiting</a></li>	
      <li><a href='$root/grid-pages/gen-grid.php?id=ONLINE_RECRUIT_MANAGEMENT'>Ad Posting</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=ADSLOGIN_MANAGEMENT'>Ads Logins</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=FAKE_REVIEW_MANAGEMENT'>Fake Reviews</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=YELP_MANAGEMENT'>Yelp Settings</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=SEO_MANAGEMENT'>SEO</a></li>		
    </ul>
  </li>	
		
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
	<li>
	<a href='#'>Candidates</a>
	<ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>
		<li><a href='$root/search-pages/candidate-search.php'>Search</a></li>
	</ul>
	</li>    
		<li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Marketing</a></li>
    </ul>
  </li>		
  
  <li>
  <a href='#'>Inside Sales</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=INSIDE_SALES_MANAGEMENT'>Inside Sales</a></li>		
	<li><a href='$root/grid-pages/gen-grid.php?id=FOLLOWUP_MANAGEMENT'>Follow up</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=REFERENCE_MANAGEMENT'>Reference</a></li>			
    	<li><a href='$root/grid-pages/gen-grid.php?id=FEEDBACK_MANAGEMENT'>Feedback</a></li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=NEWS_MANAGEMENT'>News</a></li>			
    </ul>
  </li>				
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>	  	
    	<li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>	
    </ul>
  </li>			
  <li>
  <a href='#'>Lists</a>
    <ul style='z-index: 1000;'>
    	<li>
      <a href='#'>Invitation</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Class</a></li>		
    			<li><a href='$root/grid-pages/gen-grid.php?id=JOBHELP_LIST'>Job Help</a></li>
        </ul>
      </li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=ORIENTATION_LIST'>Orientation</a></li>	   	
    </ul>
  </li>";
    }

    //Links for permission level 10 (HR Manager)
    if ($loggedInUser->checkPermission(array(10))) {
        echo "
	<li><a href='$root/ipadmin/admin_users1.php'>Users</a></li>

	<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_MANAGEMENT'>List</a></li>

    	<li>
      <a href='#'>Time</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT'>PTO</a></li>	
		  <li><a href='$root/grid-pages/gen-grid.php?id=PTO_MANAGEMENT&type=total'>PTO Total</a></li>
	  			<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>
        </ul>
      </li>				
    	<li>
      <a href='#'>Mgmt</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/grid-pages/gen-grid.php?id=EMP_REC_MANAGEMENT'>Recordings</a></li>
	  			<li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Machines</a></li>
	  			<li><a href='$root/grid-pages/gen-grid.php?id=CAN_UPDATED_PLACEMENT_INFO'>CPlacement Info</a></li>
        </ul>
      </li>    
      <li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>
      <li>
      <a href='#'>Hiring</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/grid-pages/gen-grid.php?id=EMP_LEAD_MANAGEMENT'>Leads</a></li>
        </ul>
      </li>      
    </ul>
  </li>			
	
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
   	<li><a href='$root/grid-pages/gen-grid.php?id=LEAD_MANAGEMENT'>Lead</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>
	<li><a href='$root/search-pages/candidate-search.php'>Search</a></li>
    </ul>
  </li>		

  <li>
  <a href='#'>Preparation</a>
    <ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=SESSION_MANAGEMENT'>Sessions</a></li>
    </ul>
  </li>			
	
  <li><a href='#'>Vendors</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>			
    	<li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
	    <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
		<li><a href='#'>Recruiters</a>
			<ul style='z-index: 1000;'>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
			</ul>
		</li>						
    </ul>
  </li>	
                <li><a href='#'>Clients</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/clientsearch.php'>Search</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=client'>By Client</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cplacement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=clist'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cwork'>Detailed</a></li>
							</ul>
						</li>						
                    </ul>
                </li>  
  <li>
  <a href='#'>Recruiters</a>
    <ul style='z-index: 1000;'>	
    	<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
    </ul>
  </li>	  
	
  <li>
    <a href='#'>Sales</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_LEADS_MANAGEMENT'>Client Leads</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>	
    </ul>
  </li>		
	
  <li>
    <a href='#'>Placement</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>Client</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placement</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=CAN_UPDATED_PLACEMENT_INFO'>CUpdated Placement</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=AGREEMENT_MANAGEMENT'>Agreement</a></li>
    </ul>
  </li>


	
  <li>
  <a href='#'>Time</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=PO_MANAGEMENT'>PO</a></li>	
			<li>
      <a href='#'>Timesheets</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/candidatetimesheets.php'>Uploads</a></li>		
          <li><a href='$root/grid-pages/gen-grid.php?id=C_TIMESHEET_MANAGEMENT'>Grid</a></li>		
          <li><a href='$root/search-pages/timesheet-search.php'>Search</a></li>
        </ul>
      </li>			
	    	
    </ul>
  </li>			
	
  <li>
  <a href='#'>Invoice</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_OVERDUE_MANAGEMENT'>Overdue</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_MANAGEMENT'>By PO</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=INVOICE_BYMONTH_MANAGEMENT'>By Month</a></li>
    </ul>
  </li>		

	<li>
  <a href='#'>Payment</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=C_PMT_SETUP_MANAGEMENT'>CPS</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=PAYMENT_MANAGEMENT'>Payments</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LOAN_MANAGEMENT'>Loans</a></li>						
    </ul>
  </li>		
	
  <li><a href='#'>Default</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/gen-grid.php?id=COLLECTION_AGENCY_MANAGEMENT'>Agencies</a></li>
      <li><a href='$root/grid-pages/gen-grid.php?id=CAN_DEFAULT_MANAGEMENT'>Cases List</a></li>
      <li><a href='$root/ajax-content/candidate-default.php'>Cases</a></li>
    </ul>
  </li>
	
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>	  
			<li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>
			<li><a href='http://indiavoyager.com/scans.php' target='_blank'>Scans</a></li>
			<li><a href='#'>Email System</a>
            <ul style='...'>
                <li><a href='$root/search-pages/emailtemplatemgmt.php'>Email Templates</a></li>
                <li><a href='$root/grid-pages/gen-grid.php?id=EMAIL_GROUP_MANAGEMENT'>Email Groups </a></li>
                <li><a href='$root/search-pages/emailjobmgmt.php'>Send Email</a></li>
            </ul>
            </li>
    </ul>
  </li>		
	
	<li>
  <a href='#'>Company</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=ASSET_MANAGEMENT'>Assets</a></li>
    </ul>
  </li>				
		
  <li>
  <a href='#'>Lists</a>
    <ul style='z-index: 1000;'>
    	<li>
      <a href='#'>Invitation</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/grid-pages/gen-grid.php?id=INVITATION_LIST'>Class</a></li>		
    			<li><a href='$root/grid-pages/gen-grid.php?id=JOBHELP_LIST'>Job Help</a></li>
        </ul>
      </li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=ORIENTATION_LIST'>Orientation</a></li>	   	
    </ul>
  </li>";
    }

    //Links for permission level 11 (Infrastructure Manager)
    if ($loggedInUser->checkPermission(array(11))) {
        echo "
	<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employee</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>PTO</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=EMP_REC_MANAGEMENT'>Emp Recordings</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Emp Machines</a></li>	
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>	
    </ul>
  </li>		
	
  <li>
  <a href='#'>Recruiting</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=ONLINE_RECRUIT_MANAGEMENT'>Ad Posting</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=ADSLOGIN_MANAGEMENT'>Ads Logins</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=FAKE_REVIEW_MANAGEMENT'>Fake Reviews</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=YELP_MANAGEMENT'>Yelp Settings</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=SEO_MANAGEMENT'>SEO</a></li>	   	
    </ul>
  </li>			
		
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_LIST'>Placement</a></li>	
    </ul>
  </li>		

  <li>
  <a href='#'>Preparation</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=SESSION_MANAGEMENT'>Sessions</a></li>	
      <li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IP Email</a></li>		
      	<li>
    <a href='#'>Resume</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>	
      <li><a href='$root/search-pages/resume-search.php'>Search</a></li>
    </ul>
  </li>
    </ul>
  </li>			
	
  <li>
  <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=SUBMISSION_LIST&employeeid=$employeeid&userid=$userid'>Submission</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_LIST&employeeid=$employeeid&userid=$userid'>Position</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_LIST'>Calls</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interview</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Current</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=MKT_SUBSCRIPTION_MANAGEMENT'>Subscriptions</a></li>
    </ul>
  </li>			
	
 <li>
  <a href='#'>Vendor</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>List</a></li>
			<li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
			<li><a href='#'>Recruiters</a>
				<ul style='z-index: 1000;'>
					<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
					<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
				</ul>
			</li>							
    </ul>
  </li>			
	
  <li>
  <a href='#'>Recruiter</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
    </ul>
  </li>			
	
  <li>
  <a href='#'>Sales</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_LEADS_MANAGEMENT'>Client Leads</a></li>
		  <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>	
		  <li>
      <a href='#'>Emails DB</a>
      <ul style='z-index: 1000;'>
      	<li><a href='$root/grid-pages/gen-grid.php?id=NEW_VENDOR_EMAIL_MANAGEMENT'>Recent</a></li>
		<li><a href='utils/addmassemails.php'>Add Mass Emails</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
      </ul>
      </li>								
    </ul>
  </li>		
	
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=LAB_MANAGEMENT'>Lab</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=RECORDING_MANAGEMENT'>Recordings</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=SOFTWARE_MANAGEMENT'>Software</a></li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IPEmail</a></li>	
		  <li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>			  
	    <li><a href='http://indiavoyager.com/scans.php' target='_blank'>Scans</a></li>	 	
    </ul>
  </li>				

	<li>
  <a href='#'>Company</a>
    <ul style='z-index: 1000;'>
			<li><a href='$root/grid-pages/gen-grid.php?id=ASSET_MANAGEMENT'>Assets</a></li>
    </ul>
  </li>";
    }

    //Links for permission level 12 (Marketing Admin)
    if ($loggedInUser->checkPermission(array(12))) {
        echo "
		<li>
  <a href='#'>Employee</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=EMP_LIST'>Employee</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=PTO_LIST&employeeid=$employeeid&userid=$userid'>PTO</a></li>	
    	<li><a href='$root/grid-pages/gen-grid.php?id=R_EMPTIMESHEET_MANAGEMENT&employeeid=$employeeid&userid=$userid'>Weekly</a></li>	
    	<li>
      <a href='#'>Training</a>
        <ul style='z-index: 1000;'>
          <li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
          <li><a href='$root/ajax-content/show-document.php'>Documents</a></li>			
        </ul>
      </li>	
    </ul>
  </li>			
	
  <li>
  <a href='#'>Enrollment</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=RCANDIDATE_LIST'>Candidates</a></li>
    </ul>
  </li>		
	
  <li>
  <a href='#'>Recruiting</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=ONLINE_RECRUIT_MANAGEMENT'>Ad Posting</a></li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=ADSLOGIN_MANAGEMENT'>Ads Logins</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=FAKE_REVIEW_MANAGEMENT'>Fake Reviews</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=YELP_MANAGEMENT'>Yelp Settings</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=SEO_MANAGEMENT'>SEO</a></li>	   	
    </ul>
  </li>	
	
  <li>
  <a href='#'>Inside</a>
    <ul style='z-index: 1000;'>
    	<li><a href='proxymgmt.php'>Proxy</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=REFERENCE_MANAGEMENT'>Reference</a></li>
    </ul>
  </li>	
	
  <li>
  <a href='#'>Prep</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=IP_EMAIL_MANAGEMENT'>IPEmail</a></li>	 	
				<li>
    <a href='#'>Resume</a>
    <ul style='z-index: 1000;'>
      <li><a href='$root/grid-pages/resumemgmt.php'>Resume</a></li>	
      <li><a href='$root/search-pages/resume-search.php'>Search</a></li>
    </ul>
  </li>
    </ul>
  </li>		
	
  <li>
  <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
		<li><a href='$root/grid-pages/gen-grid.php?id=SUBMISSION_LIST&employeeid=$employeeid&userid=$userid'>Submission</a></li>
    	<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_LIST&employeeid=$employeeid&userid=$userid'>Position</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=POSITION_CALL_LIST'>Calls</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=INTERVIEW_MANAGEMENT'>Interview</a></li>	
			<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_RUN_MANAGEMENT'>Mass Emails</a></li>
      <li>
      <a href='#'>MKT</a>
        <ul style='z-index: 1000;'>
    			<li><a href='$root/grid-pages/gen-grid.php?id=CANDIDATE_MKTNG_MANAGEMENT'>Complete</a></li>	
    			<li><a href='$root/grid-pages/gen-grid.php?id=CMARKETING_MANAGEMENT'>Current</a></li>			
        </ul>
      </li>		
			<li><a href='$root/grid-pages/gen-grid.php?id=MKT_SUBSCRIPTION_MANAGEMENT'>Subscriptions</a></li>		
    	<li><a href='$root/grid-pages/gen-grid.php?id=PLACEMENT_MANAGEMENT'>Placements</a></li>	  		
    </ul>
  </li>			
	
  <li>
  <a href='#'>Vendors</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_MANAGEMENT'>Vendors</a></li>			
    	<li><a href='$root/search-pages/vendorsearch.php'>Search</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=VENDOR_URL_MANAGEMENT'>URLs</a></li>
		<li><a href='#'>Recruiters</a>
			<ul style='z-index: 1000;'>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=vendor'>By Vendor</a></li>
				<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=placement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=list'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=work'>Detailed</a></li>
			</ul>
		</li>						
    </ul>
  </li>	
                <li><a href='#'>Clients</a>
                    <ul style='z-index: 1000;'>
                        <li><a href='$root/grid-pages/gen-grid.php?id=CLIENT_MANAGEMENT'>List</a></li>
                        <li><a href='$root/search-pages/clientsearch.php'>Search</a></li>
						<li><a href='#'>Recruiters</a>
							<ul style='z-index: 1000;'>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=client'>By Client</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cplacement'>By Placement</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=clist'>All List</a></li>
								<li><a href='$root/grid-pages/gen-grid.php?id=ALLRECRUITERS&type=cwork'>Detailed</a></li>
							</ul>
						</li>						
                    </ul>
                </li>  
  <li>
  <a href='#'>Recruiters</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/search-pages/recruitersearch.php'>Search</a></li>
    </ul>
  </li>			
			
	
  <li>
  <a href='#'>Sales</a>
    <ul style='z-index: 1000;'>
		  <li><a href='$root/grid-pages/gen-grid.php?id=SALE_CALL_MANAGEMENT'>Calls</a></li>
			<li><a href='$root/grid-pages/gen-grid.php?id=SALE_MEET_MANAGEMENT'>Meets</a></li>	
		  <li>
      <a href='#'>Emails DB</a>
      <ul style='z-index: 1000;'>
      	<li><a href='$root/grid-pages/gen-grid.php?id=NEW_VENDOR_EMAIL_MANAGEMENT'>Recent</a></li>
		<li><a href='utils/addmassemails.php'>Add Mass Emails</a></li>
		<li><a href='$root/grid-pages/gen-grid.php?id=MASS_EMAIL_MANAGEMENT'>List</a></li>	
      </ul>
      </li>								
    </ul>
  </li>	
	
  <li>
  <a href='#'>Infrastr</a>
    <ul style='z-index: 1000;'>
    		<li><a href='$root/grid-pages/gen-grid.php?id=LOGIN_LIST&employeeid=$employeeid&userid=$userid'>Login</a></li>	
				<li><a href='$root/grid-pages/gen-grid.php?id=EMP_MACHINE_MANAGEMENT'>Emp Machines</a></li>
				<li><a href='$root/grid-pages/gen-grid.php?id=SOFTWARE_MANAGEMENT'>Softwares</a></li>	
				<li><a href='$root/grid-pages/gen-grid.php?id=DOCUMENT_MANAGEMENT'>Documents</a></li>	 		    
    </ul>
  </li>";
    }


    //Links for permission level 13 and  14 (Candidate)
    if ($loggedInUser->checkPermission(array(14)) or $loggedInUser->checkPermission(array(13))) {
        echo "
	
  <li>
    <a href='#'>Intro</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/search-pages/candidate-intro.php'>Info</a></li>
    	<li><a href='$root/search-pages/can-postenrollment-info-mgmt.php'>Personal Information</a></li>
    	<li><a href='$root/search-pages/can-postplacement-infomgmt.php'>Work Information</a></li>
      <li>
        <a href='#'>How To</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/search-pages/training-videos.php'>Videos</a></li>
        	<li><a href='$root/search-pages/show-document.php'>Documents</a></li>					
        </ul>
      </li>				
    </ul>
  </li>		
	
  <li>
    <a href='#'>Training</a>
		<ul style='z-index: 1000;'>
      <li>
        <a href='#'>Classes</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/search-pages/candidateassignmentmgmt.php'>Assignments</a></li>
					<li><a href='$root/grid-pages/gen-grid.php?id=CAN_TEST_MANAGEMENT'>Test Questions</a></li>
        	<li><a href='$root/search-pages/notesmgmt.php'>Notes</a></li>	        	
        </ul>
      </li>			
      <li>
        <a href='#'>Questions</a>
        <ul style='z-index: 1000;'>
        	<li><a href='$root/search-pages/candidateanswermgmt.php'>Try</a></li>		
					<li><a href='$root/search-pages/can-answer-search.php'>Answers</a></li>			
        </ul>
      </li>	
			</ul>			
  </li>			
	
  <li>
    <a href='#'>Preparation</a>
    <ul style='z-index: 1000;'>
    	<li><a href='$root/search-pages/coverletter.php?userid=$userid'>Cover Letter</a></li>
      <li>
        <a href='#'>Resume</a>
        <ul style='z-index: 1000;'>
				  <li><a href='$root/search-pages/resume-notes.php'>Resume</a></li>	
        	<li><a href='$root/search-pages/resume-search.php'>Search Others</a></li>
        </ul>
      </li>
			
			<li><a href='$root/grid-pages/gen-grid.php?id=CAN_SESSIONS'>Sessions</a></li>
    </ul>
  </li>		
	
  <li>
    <a href='#'>Marketing</a>
    <ul style='z-index: 1000;'>
    	
		<li><a href='$root/grid-pages/gen-grid.php?id=CAN_POSITIONS'>My Positions</a></li>
			<li><a href='$root/search-pages/can-position-call.php'>Calls</a></li>	
					
    </ul>
  </li>
  <li>
        <a href='#'>Interviews</a>
        <ul style='z-index: 1000;'>
				  
				  <li><a href='$root/grid-pages/gen-grid.php?id=CAN_INTERVIEWS'>My Interviews</a></li>
        	<li><a href='$root/search-pages/can-interview-mgmt.php'>Questions</a></li>
        </ul>
      </li>
					
    		<li>
      			<a class='onproject' href='$root/search-pages/can-timesheet.php'>Timesheets</a>
        </li>		
				<li>
   					<a class='onproject' href='$root/search-pages/can-project.php'>Project</a>
  			</li>
	      ";


    }
    echo "</ul>";
} //Links for users not logged in
else {
    echo "
	<ul id='mymenu'>
	<nav class='nav nav-pills nav-stacked'></nav>
	<div class='nav nav-pills nav-stacked'></div>
	<li class ='active'><a href='$root/index.php'>Home</a></li>
	<li class ='active'><a href='$root/login.php'>Login</a></li>
	<li class='active'><a href='$root/register.php'>Register</a></li>";
    //<li><a href='$root/forgot-password.php'>Forgot Password</a></li>
    //if ($emailActivation)
    //{
    //echo "<li><a href='$root/resend-activation.php'>Resend Activation Email</a></li>";
    //}
    echo "</ul>";
}

?>