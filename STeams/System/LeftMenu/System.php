   "01_Sessions" => array
   (
      "Href" => "?Action=Sessions",
   ),
   "30_Languages" => array
   (
      "Href" => "?ModuleName=Languages&Action=Search",
      "Target" => "Languages",
      "AccessMethod" => "MyMod_Messages_Access_Has",
   ),
   "40_Messages" => array
   (
      "Href" => "?".$this->CGI_Hash2URI
      (
          array_merge
          (
              $this->CGI_URI2Hash(),
              array
              (
                  "Messages" => 1,
              )
          )
      ),
      "AccessMethod" => "MyMod_Messages_Access_Has",
   ),

