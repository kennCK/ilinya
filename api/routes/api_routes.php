<?php
/* Add the undescore case of the controller, no need to specify crud operations*/
$apiResources = [
  'modules',
  'business_type',
  'company',
  'company_logo',
  'company_branch',
  'company_branch_employee',
  'position',
  'api_test_results',
  'account',
  'account_type',
  'account_information',
  'queue_form',
  'queue_form_field',
  'queue_card',
<<<<<<< HEAD
  'queue_card_field',
  'announcement',
  'ilinya'
=======
  'queue_card_field'
>>>>>>> 4624ae07c4144ca029d8fcee1d98ff7ef957f92c
];
api_resource($apiResources);

?>