console.log("dev guide js is loaded...");

let cookie = document.cookie.split("; ");
let cookie_split = {}

cookie.map((obj) => {
    let temp = obj.split("=");
    cookie_split[temp[0]] = temp[1];
});

if(decodeURIComponent(cookie_split.ga_at_encode))
{
    let decoded_cookie = window.atob(decodeURIComponent(cookie_split.ga_at_encode));
    console.log("unencoded cookie: "+cookie_split.ga_at);
    console.log("encoded cookie: "+decodeURIComponent(cookie_split.ga_at_encode));
    console.log("decoded cookie: "+decoded_cookie);

    generate_dev_guide(decoded_cookie);
}

function generate_dev_guide(ga)
{
    // enable generate sheet button
    $("#generate-sheet-dev-guide").removeClass("disabled");

    $("#generate-sheet-dev-guide").on("click", async function(){
        let inp_id = $("#inp-dev-guide-id").val();
        let dev_guide_type = $("#inp-dev-guide-type").val();
        let valid_dev_guide_type = ["web","app"];
        let valid_tab_name = ["overview","tracking","legend"];
        
        var sheet_list = [];

        console.log(inp_id);
        console.log(dev_guide_type);
        if(!valid_dev_guide_type.includes(dev_guide_type))
        {
            console.log("invalid dev guide type");
            alert("Please select valid Developer Guide type");
            return;
        }

        if(inp_id)
        {
            var prepared_inp_id = prepare_inp_id(inp_id);

            let endpoint_sheet = "https://sheets.googleapis.com/v4/spreadsheets/" + prepared_inp_id;

            let response = await fetch(endpoint_sheet,{method: "get", headers:{Authorization: "Bearer " + ga}})
            .then((response) => response.json())
            .then((data) => {
                return data;
            });
            console.log(response);
            if(response.error)
                error_alert(response.error.code,response.error.status,response.error.message);

            if(typeof response.sheets !== "undefined" && response.sheets)
            {
                if(response.properties.title.includes("Tracking Specifications Sheet"))
                {
                    console.log(response.properties.title);
                    console.log("-----------------------------------");
                    response.sheets.map((sheet) => {
                        console.log(sheet.properties.sheetId);
                        console.log(sheet.properties.title);
                        console.log("-----------------------------------");
                        if(!valid_tab_name.includes(sheet.properties.title.toLowerCase())){
                            console.log("invalid tab name");
                            alert("invalid tab name");
                            sheet_list = [];
                            return ;
                        }
                        else
                            sheet_list.push({
                                spreadsheet_id : prepared_inp_id,
                                title : sheet.properties.title,
                                sheet_id : sheet.properties.sheetId,
                                column_count : sheet.properties.gridProperties.columnCount,
                                row_count : sheet.properties.gridProperties.rowCount
                            });
                    });
                }
                else
                {
                    console.log("is not Tracking Specifications Sheet");
                    alert("is not Tracking Specifications Sheet");
                }
                console.log(prepared_inp_id);
                console.log(sheet_list);
            }

            sheet_list.map(async (sheet) => {
                endpoint_sheet = "https://sheets.googleapis.com/v4/spreadsheets/" + sheet.spreadsheet_id + "/values/" + sheet.title + "!A1:Z" + sheet.row_count;

                response = await fetch(endpoint_sheet,{method: "get", headers:{Authorization: "Bearer " + ga}})
                .then((response) => response.json())
                .then((data) => {
                    return data;
                });
                console.log(response);
            });
            
        }
        else
        {
            console.log("inp id is empty, please fill up the proper input id");
            alert("inp id is empty, please fill up the proper input id");
        }
    });
}

function prepare_inp_id(inp_id)
{
    if(inp_id.includes("spreadsheets") || inp_id.includes("docs.google.com"))
    {
        let temp = inp_id.split('/');
        temp.map((str_slice,index) => {
            if(str_slice == "d")
            {
                inp_id = temp[index+1];
                return;
            }
        });
    }
    return inp_id;
}

function error_alert(code, status, message="")
{
    alert("Error " + code + " : " + status + "\n" + message);
    console.log("-----------------------------------");
    console.log(code);
    console.log(message);
    console.log(status);
    console.log("-----------------------------------");
}