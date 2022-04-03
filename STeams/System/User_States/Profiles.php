<?php
array
(
   'Access' => array
   (
      'Public' => 0,
      'Person' => 0,
      'Admin' => 1,

      "Clerk" => 1,
      "Teacher"     => 1,
      "Secretary" => 1,
      "Coordinator" => 0,
   ),
   'Actions' => array
   (
      'Search' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
         "Coordinator" => 0,
      ),
      'Add' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'ComposedAdd' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Copy' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Show' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,
         "HrefArgs" => "ID=#ID&Date=#Date",

         "Clerk" => 1,
         "Teacher"     => 0,
         "Secretary" => 1,
         "Coordinator" => 1,
      ),
      'ShowList' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 1,
         "Teacher"     => 1,
         "Secretary" => 1,
         "Coordinator" => 0,
      ),
      'Edit' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
     ),
      'EditList' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Delete' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Latex' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 1,
         "Teacher"     => 1,
         "Coordinator" => 1,
         "Secretary" => 1,
      ),
      'LatexList' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 1,
         "Teacher"     => 1,
         "Secretary" => 1,
         "Coordinator" => 1,
      ),
      'Print' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 1,
         "Teacher"     => 1,
         "Secretary" => 1,
     ),
      'PrintList' => array
      (
         'Public' => 1,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 1,
         "Teacher"     => 1,
         "Coordinator" => 1,
         "Secretary" => 1,
      ),
      'Download' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
         "Coordinator" => 0,
      ),
      'Export' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Import' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Zip' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 0,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Process' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'SysInfo' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Profiles' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
     'Log' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Backup' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'Setup' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
      'NewPassword' => array
      (
         'Public' => 0,
         'Person' => 0,
         'Admin' => 1,

         "Clerk" => 0,
         "Teacher"     => 0,
         "Secretary" => 0,
      ),
   ),
   'Menues' => array
   (
      'Singular' => array
      (
         'Public' => array
         (
            'Show' => 1,
         ),
         'Person' => array
         (
         ),
         'Admin' => array
         (
            'Show' => 1,
            'Delete' => 1,
         ),
         'Coordinator' => array
         (
            'Show' => 1,
         ),
         'Clerk' => array
         (
            'Show' => 1,
         ),
         'Teacher' => array
         (
            'Show' => 1,
         ),
         'Secretary' => array
         (
            'Show' => 1,
         ),
      ),
      'Plural' => array
      (
         'Public' => array
         (
            'Search' => 1,
         ),
         'Person' => array
         (
         ),
         'Admin' => array
         (
         ),
         'Coordinator' => array
         (
         ),
         'Clerk' => array
         (
         ),
         'Teacher' => array
         (
         ),
         'Secretary' => array
         (
         ),
      ),
      'SingularPlural' => array
      (
         'Public' => array
         (
            'Logs' => 1,
         ),
         'Person' => array
         (
         ),
         'Admin' => array
         (
            'Logs' => 1,
         ),
         'Coordinator' => array
         (
            'Logs' => 1,
         ),
         'Clerk' => array
         (
            'Logs' => 1,
         ),
         'Teacher' => array
         (
            'Logs' => 1,
         ),
         'Secretary' => array
         (
             'Logs' => 1,
         ),
      ),
      'ActionsPlural' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         'Admin' => array
         (
         ),
         'Clerk' => array
         (
         ),
         'Teacher' => array
         (
         ),
         'Secretary' => array
         (
         ),
      ),
      'ActionsSingular' => array
      (
         'Public' => array
         (
         ),
         'Person' => array
         (
         ),
         'Admin' => array
         (
         ),
         'Clerk' => array
         (
         ),
         'Teacher' => array
         (
         ),
         'Secretary' => array
         (
         ),
      ),
   ),
);
?>