<?php 
    function index(){
        return view('index');
    }

    function tab1(){
        return respond(runCommand("hostname"),200);
    }

    function tab2(){
        $certList = runCommand("awk -F: '{ print $1}' /etc/passwd");
        $certList = explode("\n",$certList);
    
        $data = [];
        foreach($certList as $item){
            if ($item != "") {
                $data[] = [
                    "path" => $certString,
                    "ip" => $item
                ];
            }
        }
    
        return view('table', [
            "value" => $data,
            "title" => ["*hidden*","Sertifika Adı" ],
            "display" => ["path:path","ip"],
        ]);
    }
?>