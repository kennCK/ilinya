<?php
/* Add the undescore case of the controller, no need to specify crud operations*/
$apiResources = [
  'modules',
  'business_type',
  'company',
  'company_logo',
  'company_branch',
  'company_branch_employee',
  'department',
  'department_member',
  'position',
  'api_test_results',
  'account',
  'account_type',
  'account_information',
  'account_profile_picture',
  'account_schedule',
  'account_position',
  'employee_status',
  'schedule'
];
api_resource($apiResources);

?>