array
(
    "Help" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Ajuda #ItemsName",
        "Title_UK" => "Help #ItemsName_UK",
        "Title_ES" => "Ayuda #ItemsName_ES",
        "Name"     => "Ajuda #ItemsName",
        "Name_UK"  => "Help #ItemsName_UK",
        "Name_ES"     => "Ayuda #ItemsName_ES",
        "ShortName"     => "Ajuda #ItemsName",
        "ShortName_UK"  => "Help #ItemsName_UK",
        "ShortName_ES"     => "Ayuda #ItemsName_ES",

        "Icon"     => "fas fa-question",
        "Public"   => 1,
        "Person"   => 1,
        "Admin"    => 1,

        "Handler"       => "MyMod_Handle_Help",
        "AccessMethod"  => "MyMod_Handle_Help_Has",

        "Singular"   => FALSE,
    ),
    "Search" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Pesquisar #ItemsName",
        "Title_UK" => "Search #ItemsName_UK",
        "Title_ES" => "Pesquisar #ItemsName_ES",
        "Name"     => "Pesquisar #ItemsName",
        "Name_UK"  => "Search #ItemsName_UK",
        "Name_ES"  => "Pesquisar #ItemsName_ES",
        "ShortName"     => "Pesquisar",
        "ShortName_UK"  => "Search",
        "ShortName_ES"  => "Pesquisar",

        "Icon"     => "fas fa-search",
        
        "Icon_Even" => "fas fa-search",
        "Icon"      => "fas fa-search",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Search",
        //"AltAction"   => "EditList",
        "Edits"   => 0,
        //"NoHeads"   => 1,
        //"NoInterfaceMenu"   => 1,
        "Singular"   => FALSE,
    ),
    "Add" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Criar novo(a) #ItemName",
        "Title_UK" => "Create #ItemName_UK",
        "Title_ES" => "Criar nuevo(a) #ItemName_ES",
        "Name"     => "Adicionar #ItemName",
        "Name_UK"  => "Add #ItemName_UK",
        "Name_ES"  => "Adicionar #ItemName_ES",
        "ShortName"     => "Adicionar",
        "ShortName_UK"  => "Add",
        "ShortName_ES"     => "Adicionar",

        "PName"     => "#ItemName adicionado com êxito",
        "PName_UK"  => "#ItemName_UK successfully added",
        "PName_ES"  => "#ItemName_UK adicionado com exito",
        
        "Icon_Even" => "fas fa-plus",
        "Icon"      => "fas fa-plus-circle",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Add",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 1,
        "Singular"   => FALSE,
    ),
    "Copy" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Copiar #ItemName #Name",
        "Title_UK" => "Copy #ItemName_UK #Name_UK",
        "Title_ES"    => "Copiar #ItemName_ES #Name",
        "Name"     => "Copiar #ItemName",
        "Name_UK"  => "Copy #ItemName_UK",
        "Name_ES"     => "Copiar #ItemName_ES",
        "PName"     => "#ItemName copiado com êxito",
        "PName_UK"  => "#ItemName_UK successfully copied",
        "PName_ES"     => "#ItemName_ES copiado con exito",
        
        "Icon"          => "fas fa-copy",
        "Icon_Even"     => "far fa-copy",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Copy",
        //"NoHeads"   => 1,
        //"NoInterfaceMenu"   => 1,
        "Edits"   => 1,
        "Singular"   => TRUE,
    ),
    "Show" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Mostrar #ItemName",
        "Title_UK" => "Show #ItemName_UK",
        "Title_ES"    => "Mostrar #ItemName_ES",
        "Name_UK"  => "Show #ItemName_UK",
        "Name"     => "Mostrar #ItemName",
        "Name_ES"     => "Mostrar #ItemName_ES",
        
        "Icon"           => "fas fa-eye",
        "Icon_Even"      => "far fa-eye",
        
        "ShowIDCols"     => array(),
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Show",
        //"Target"   => "_#Module",
        "Edits"   => 0,
        "Singular"   => TRUE,
        "AltAction"   => "Edit",
    ),
    "Edit" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Editar #ItemName",
        "Title_ES"    => "Editar #ItemName_ES",
        "Title_UK" => "Edit #ItemName_UK",
        "Name"     => "Editar #ItemName",
        "Name_UK"  => "Edit #ItemName_UK",
        "Name_ES"     => "Editar #ItemName_ES",
        
        "Icon"         => "fas fa-edit",
        "Icon_Even"     => "far fa-edit",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "AltAction"   => "Show",
        "Handler"   => "MyMod_Handle_Edit",
        //"Target"   => "_#Module",
        "Edits"   => 1,
        "Singular"   => TRUE,
    ),
    "EditList" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Editar #ItemsName em Lista",
        "Title_UK" => "Edit #ItemsName_UK in List",
        "Title_ES"    => "Editar #ItemsName_ES en Lista",
        "Name"     => "Editar #ItemsName",
        "Name_UK"  => "Edit #ItemsName_UK",
        "Name_ES"     => "Editar #ItemsName_ES",
        "ShortName"     => "Editar em Lista",
        "ShortName_UK"  => "Edit in List",
        "ShortName_ES"     => "Editar em Lista",

        "Icon"         => "fas fa-edit",
        "Icon_Even"     => "far fa-edit",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Search",
        "AltAction"   => "Search",
        "Edits"   => 1,
        "Edit"   => 1,
        "Singular"   => FALSE,
    ),
    "Delete" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Deletar #ItemName",
        "Title_UK" => "Delete #ItemName_UK",
        "Title_ES"    => "Deletar #ItemName_ES",
        "Name"     => "Deletar #ItemName",
        "Name_ES"     => "Deletar #ItemName_ES",
        "Name_UK"  => "Delete #ItemName_UK",
        "PName"     => "#ItemName deletado com êxito",
        "PName_ES"     => "#ItemName_ES deletado con exito",
        "PName_UK"  => "#ItemName_UK successfully deleted",
        
        "Icon"          => "fas fa-trash",
        "Icon_Even"     => "fas fa-trash-alt",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 0,
        //"Target"   => "_delete",
        "Handler"   => "MyMod_Handle_Delete",
        "NoHeads"   => 1,
        "Confirm"   => 1,
        "ConfirmTitle"   => "MyMod_Handle_Delete_Confirm_Message",
        "Edits"   => 1,
        "Singular"   => TRUE,
    ),
    "Print" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Imprimir",
        "Title_UK" => "Print",
        "Title_ES"    => "Imprimir",
        "Name"     => "Versão Imprimível",
        "Name_UK"  => "Printable Version",
        "Name_ES"     => "Versión Imprimíble",

        "Icon_Even"  => "far fa-file-pdf",
        "Icon"       => "fas fa-file-pdf",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Print",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Singular"   => TRUE,
        "Icon" => 'fas fa-file-pdf',
    ),
    "Prints" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Gerar Imprimíveis em Lista",
        "Title_UK" => "Printables in List",
        "Title_ES"    => "",
        
        "Name"     => "Imprimíveis",
        "Name_UK"  => "Printables",
        "Name_ES"     => "Imprimíbles",

        "Icon_Even"  => "far fa-file-pdf",
        "Icon"       => "fas fa-file-pdf",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Prints",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Icon" => 'fas fa-file-pdf',
    ),
    "Download" => array
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Baixar #Name",
        "Title_UK" => "Download #Name",
        "Title_ES"    => "Descarregar #Name",
        "Name"     => "Baixar",
        "Name_UK"  => "Download",
        "Name_ES"     => "Descarregar",
        "Icon"     => "fas fa-download",
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Download",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Singular"   => True,
    ),
    "Unlink" => array //Unlink downloads
    (
        "Href"     => "",
        "HrefArgs" => "ID=#ID",
        "Title"    => "Deletar #Name",
        "Title_UK" => "Delete #Name",
        "Title_ES"    => "Deletar #Name",
        "Name"     => "Deletar",
        "Name_UK"  => "Delete",
        "Name_ES"     => "Deletar",

        "Icon"          => "fas fa-trash-alt",
        "Icon_Even"     => "fas fa-trash",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Unlink",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Singular"   => FALSE,
        "Confirm"   => FALSE,
    ),
    "Export" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Exportar #ItemsName (dump)",
        "Title_UK" => "Export #ItemsName_UK (dump)",
        "Title_ES"    => "Exportar #ItemsName_ES (dump)",
        "Name"     => "Exportar #ItemsName",
        "Name_UK"  => "Export #ItemsName_UK",
        "Name_ES"     => "Exportar #ItemsName_ES",

        "Icon"        => "fas fa-download",
        "Icon_Even"   => "fas fa-download",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Export",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Singular"   => FALSE,
       
    ),
    "Import" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Importar #ItemsName do Arquivo",
        "Title_UK" => "Import #ItemsName_UK",
        "Title_ES"    => "Importar #ItemsName_ES de Ficheiro",
        "Name"     => "Importar",
        "Name_UK"  => "Import",
        "Name_ES"     => "Importar",

        "Icon"          => "fas fa-upload",
        "Icon_Even"     => "fas fa-upload",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 0,
        "Handler"   => "HandleImport",
        "Singular"   => FALSE,
        "AccessMethod" => "CheckEditListAccess",
    ),
    "Zip" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Zipar Arquivos Carregados",
        "Title_UK" => "Zip Uploaded Files",
        "Title_ES"    => "Zipar Archivos Carregados",
        "Name"     => "Zipar Arquivos",
        "Name_UK"  => "Zip Files",
        "Name_ES"     => "Zipar Archivos",

        "Icon"          => "far fa-archive",
        "Icon_Even"     => "fas fa-archive",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Zip",
        "NoHeads"   => 1,
        "NoInterfaceMenu"   => 1,
        "Edits"   => 0,
        "Singular"   => FALSE,
    ),
    "Files" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "Title"    => "Arquivos Carregados",
        "Title_UK" => "Uploaded Files",
        "Title_ES"    => "Archivos Carregados",
        "Name"     => "Arquivos",
        "Name_UK"  => "Files",
        "Name_ES"     => "Archivos",
        

        "Icon"          => "far fa-folder",
        "Icon_Even"     => "fas fa-folder",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Handler"   => "MyMod_Handle_Files",
        "Edits"   => 0,
        "Singular"   => FALSE,
    ),
    "Info" => array
    (
        "NoHeads"       => True,
        "Href"     => "",
        "HrefArgs" => "",
        "AddIDArg"   => 0,
        "Title"    => "SysInfo",
        "Title_UK" => "SysInfo",
        "Title_ES"    => "SysInfo",
        "Name"     => "SysInfo",
        "Name_UK"  => "SysInfo",
        "Name_ES"     => "SysInfo",
        
        "Icon"          => "fas fa-info",
        "Icon_Even"     => "fas fa-info-circle",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Singular"   => FALSE,
        "Handler"  => "MyMod_Handle_Info",
        "Anchor"        => "HorMenu",
        "AccessMethod" => "CheckEditListAccess",
    ),
    "Test" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "AddIDArg"   => 0,
        "Title"    => "Teste",
        "Title_UK" => "Test",
        "Title_ES"    => "Teste",
        "Name"     => "Teste",
        "Name_UK"  => "Test",
        "Name_ES"     => "Teste",
        
        "Icon"          => "fas fa-info",
        "Icon_Even"     => "fas fa-info-circle",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Singular"   => FALSE,
        "Handler"  => "MyMod_Handle_Test",
        "Anchor"        => "HorMenu",
        "AccessMethod" => "CheckEditListAccess",
    ),
    "Select" => array
    (
        "Href"     => "",
        "HrefArgs" => "",
        "AddIDArg"   => 0,
        "Title"    => "Select",
        "Title_UK" => "Select",
        "Title_ES"    => "Select",
        "Name"     => "Select",
        "Name_UK"  => "Select",
        "Name_ES"     => "Select",
        
        "Public"   => 0,
        "Person"   => 0,
        "Admin"   => 1,
        "Singular"   => FALSE,
        
        "Handler"  => "MyMod_Handle_Select",
        "NoHeads"  => True,
    ),
);
