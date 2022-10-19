// selectpicker dropdown property
$(".selectpicker").selectpicker({
    zIndex:1,
    width:'400px'
});
$('.selectpicker').selectpicker('refresh');

function setup_dropdown(){
    let cookie = document.cookie.split("; ");
    let cookie_split = {}

    cookie.map((obj) => {
        let temp = obj.split("=");
        cookie_split[temp[0]] = temp[1];
    });

    console.log("unencoded cookie: "+cookie_split.ga_at);
    console.log("encoded cookie: "+decodeURIComponent(cookie_split.ga_at_encode));
    console.log("decoded cookie: "+window.atob(decodeURIComponent(cookie_split.ga_at_encode)));


    if(typeof cookie_split.ga_at_encode !== 'undefined') //if logging worked
    {
        let decoded_ga_at = window.atob(decodeURIComponent(cookie_split.ga_at_encode));
        let construct_obj = {};

        alert_popup('#alert-login-success',2000);

        // //account
        console.log("GTM acc setup...");

        var endpoint_account = "https://"+location.hostname+":20006/api/account";
        console.log("fetch internal api:" + endpoint_account);

        console.log("change acc...");

        fetch(endpoint_account,{method: "get", headers:{Authorization: decoded_ga_at}})
        .then((response) => response.json())
        .then((data) => append_to_dropdown(data))
        .then(() => {
            enable_dropdown("account");
            console.log("GTM acc setup completed...");
        });

        //container
        $("#GTM-account-dropdown").on("change",function(){

            disable_dropdown("container");
            disable_dropdown("workspace");

            $("#generate-sheet").addClass("disabled");

            //insert new gtm-account info
            construct_obj.account_id = $(this).children(":selected").attr("id");

            if(typeof $(this).children(":selected").attr("id") !== "undefined" && $(this).children(":selected").attr("id") !== "none")
            {
                console.log("GTM container setup...");

                var endpoint_container = "https://"+location.hostname+":20006/api/account/"+$(this).children(":selected").attr("id")+"/container";
                console.log("fetch internal api:" + endpoint_container);
    
                console.log("change container...");
    
                fetch(endpoint_container,{method: "get", headers:{Authorization: decoded_ga_at}})
                .then((response) => response.json())
                .then((data) => {
                    if(data)
                        append_to_dropdown(data);
                })
                .then(() => {
                    enable_dropdown("container");
                    console.log("GTM container setup completed...");
                });
            }
        });

        //workspace
        $("#GTM-container-dropdown").on("change",function(){

            disable_dropdown("workspace");

            $("#generate-sheet").addClass("disabled");

            //insert new gtm-container info
            construct_obj.container_id = $(this).children(":selected").attr("id");

            if(typeof $(this).children(":selected").attr("id") !== "undefined" && $(this).children(":selected").attr("id") !== "none")
            {
                console.log("GTM workspace setup...");

                var endpoint_container = "https://"+location.hostname+":20006/api/account/"+$("#GTM-account-dropdown").children(":selected").attr("id")+"/container/"+$(this).children(":selected").attr("id")+"/workspace";
                console.log("fetch internal api:" + endpoint_container);

                console.log("change workspace...");

                fetch(endpoint_container,{method: "get", headers:{Authorization: decoded_ga_at}})
                .then((response) => response.json())
                .then((data) => {
                    if(data)
                        append_to_dropdown(data);
                })
                .then(() => {
                    enable_dropdown("workspace");
                    console.log("GTM workspace setup completed...");
                });
            }
            else
            {
                console.log("container id invalid");
            }
        });

        $("#GTM-workspace-dropdown").on("change",function(){
            $("#generate-sheet").addClass("disabled");

            //insert new gtm-workspace info
            construct_obj.workspace_id = $(this).children(":selected").attr("id");

            if(typeof $(this).children(":selected").attr("id") !== "undefined" && $(this).children(":selected").attr("id") !== "none")
            {
                $("#generate-sheet").removeClass("disabled");
                console.log(construct_obj);
            }
        });
    }
}

function enable_dropdown(id){
    $('select#GTM-'+id+"-dropdown").prop("disabled", false);
    // $("#GTM-" + id + "-dropdown").empty();
    // $('.selectpicker').selectpicker('refresh');
    clear_dropdown(id);
}

function disable_dropdown(id){
    $("select#GTM-"+id+"-dropdown").empty();
    $("select#GTM-"+id+"-dropdown").attr("disabled", true);
    // $("#GTM-" + id + "-dropdown").empty();
    // $('.selectpicker').selectpicker('refresh');
    clear_dropdown(id);
}

function append_to_dropdown($json){
    var key = Object.keys($json)[0];
    console.log(key);
    switch(key.toLowerCase()) {
        case "account":
            /*
            {
                "path": "accounts/99985",
                "accountId": "99985",
                "name": "Kasatria"
            }
            */
            console.log("account dropdown edit");

            $("#GTM-account-dropdown").append("<option id='none'> None </option>");
            $json.account.map(e => {
                console.log(e.name);
                $("#GTM-account-dropdown").append("<option id='"+e.accountId+"'> ("+e.accountId+") "+e.name+"</option>");
            });
            $('#GTM-account-dropdown').selectpicker('refresh');

            break;
        case "container":
            /* 
            {
                "path": "accounts/99985/containers/112465",
                "accountId": "99985",
                "containerId": "112465",
                "name": "Bodyshop Malaysia",
                "domainName": [
                    "http://www.thebodyshop.com.my",
                    "https://www.thebodyshop.com.my"
                ],
                "publicId": "GTM-J7PT",
                "usageContext": [
                    "web"
                ],
                "fingerprint": "1469484212575",
                "tagManagerUrl": "https://tagmanager.google.com/#/container/accounts/99985/containers/112465/workspaces?apiLink=container"
            }
            */
            console.log("container dropdown edit");

            $("#GTM-container-dropdown").append("<option id='none'> None </option>");
            $json.container.map(e => {
                console.log(e.name);
                $("#GTM-container-dropdown").append("<option id='"+e.containerId+"'> ("+e.publicId+") "+e.name+"</option>");
            });
            $('#GTM-container-dropdown').selectpicker('refresh');
            
            break;
        case "workspace":
            /*
            {
                "path": "accounts/99985/containers/112465/workspaces/5",
                "accountId": "99985",
                "containerId": "112465",
                "workspaceId": "5",
                "name": "Default Workspace",
                "fingerprint": "1469484212575",
                "tagManagerUrl": "https://tagmanager.google.com/#/container/accounts/99985/containers/112465/workspaces/5?apiLink=workspace"
            }
            */
            console.log("workspace dropdown edit");
            $("#GTM-workspace-dropdown").append("<option id='none'> None </option>");
            $json.workspace.map(e => {
                console.log(e.name);
                $("#GTM-workspace-dropdown").append("<option id='"+e.workspaceId+"'>"+e.name+"</option>");
            });
            $('#GTM-workspace-dropdown').selectpicker('refresh');
            
            break;
        default:
            console.log($json)

            return "error: json key is invalid";
    }
}

function clear_dropdown(selected_to_clear)
{
    var predefined_val = ['account','container','workspace'];
    selected_to_clear = selected_to_clear.toLowerCase();

    if(predefined_val.includes(selected_to_clear))
    {
        $("select#GTM-" + selected_to_clear + "-dropdown").selectpicker("destroy");
        $("select#GTM-" + selected_to_clear + "-dropdown").selectpicker({
            zIndex:1,
            width:'400px'
        });
        $('.selectpicker').selectpicker('refresh');
    }
    else
        console.log("cannot clear dropdown, argument is not included in predefined_val");
}

function alert_popup(selector, exist_duration=2000, anim_duration=400){
	if(exist_duration < anim_duration*2)
  	exist_duration = anim_duration*2 + 200;

	$(selector).slideDown(anim_duration);
    setTimeout(function(){
      $(selector).slideUp(anim_duration);
    }, exist_duration);
}