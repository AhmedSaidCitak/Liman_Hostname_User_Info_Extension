<h1>{{ __('Sunucu Bilgileri') }}</h1>
{{ __('Hostname') }}: <span id="hostname"></span><br/>

@include('modal-button',[
    "class"     => "btn btn-primary mb-2",
    "target_id" => "setHostnameModal",
    "text"      => "Hostname Değiştir",
    "icon"      => "fas fa-plus"
])

@include('modal',[
    "id" => "setHostnameModal",
    "title" => "Hostname Değiştir",
    "url" => API('set_hostname'),
    "next" => "getHostname",
    "inputs" => [
        "Hostname" => "hostname:text"
    ],
    "submit_text" => "Hostname Değiştir"
])

<ul class="nav nav-tabs" role="tablist" style="margin-bottom: 15px;">
    <li class="nav-item">
        <a class="nav-link active"  onclick="tab1()" href="#tab1" data-toggle="tab">Sunucu İsmi</a>
    </li>
    <li class="nav-item">
        <a class="nav-link "  onclick="tab2()" href="#tab2" data-toggle="tab">Kullanıcı Listesi</a>
    </li>
</ul>

<div class="tab-content">
    <div id="tab1" class="tab-pane active">
    </div>

    <div id="tab2" class="tab-pane">
    </div>
</div>

<div id="tab2" class="tab-pane">
    <div id="caCertificatePrintArea">
        <div class="table-responsive caCertsTable" id="caCertsTable"></div> 
    </div>
</div>

<script>

   if(location.hash === ""){
        tab1();
    }

    function tab1(){
        var form = new FormData();
        request("{{API('tab1')}}", form, function(response) {
            message = JSON.parse(response)["message"];
            $('#tab1').html(message);
        }, function(error) {
            $('#tab1').html("Hata oluştu");
        });
    }

    function tab2(){
        showSwal('{{__("Yükleniyor...")}}','info',2000);
        var form = new FormData();
        request("{{API('tab2')}}", form, function(response) {
            $('#tab2').html(response).find('table').DataTable({
            bFilter: true,
            "language" : {
                url : "/turkce.json"
            }
            });;
        }, function(response) {
            let error = JSON.parse(response);
            showSwal(error.message, 'error', 3000);
        });
    }

    getHostname();
    function getHostname(){
        showSwal('{{__("Yükleniyor...")}}', 'info');
        let data = new FormData();
        request("{{API("get_hostname")}}", data, function(response){
            response = JSON.parse(response);
            $('#hostname').text(response.message);
            Swal.close();
            $('#setHostnameModal').modal('hide')
        }, function(response){
            response = JSON.parse(response);
            showSwal(response.message, 'error');
        });
    }

</script>