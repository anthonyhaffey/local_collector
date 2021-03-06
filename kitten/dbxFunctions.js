// Dropbox functions below
//////////////////////////
dbx_obj = {
	queing:false,
	queue : [],
	new_upload : function(item,successFunction,failFunction,upload_type){
		dbx_obj.queue.push([item,successFunction,failFunction,upload_type]);
		if(dbx_obj.queing == false){
			$("#save_status").html("Synching...");
			$("#save_status").show(500);
			dbx_obj.queing = true;
			dbx_obj.upload();
		}
	},
	upload:function(){
		[item,successFunction,failFunction,upload_type] = dbx_obj.queue.shift();
		dbx[upload_type](item)
			.then(function(result){
				successFunction(result);
				if(dbx_obj.queue.length > 0){
					dbx_obj.queing = true;
					dbx_obj.upload();
				}	else 	{
					dbx_obj.queing = false;
					$("#save_status").html("Up to date");
					setTimeout(function(){
						$("#save_status").hide(500);
					},500);
				}
			})
			.catch(function(error){
				failFunction(error);
			});
	}
}
function initiate_uberMegaFile(){
	dbx.sharingCreateSharedLink({path:"/uberMegaFile.json"})
		.then(function(link_created){
			load_uberMegaFile(link_created);
		})
		.catch(function(error){ //i.e. this is the first login
			dropbox_dialog = bootbox.dialog({
				title: "Your first login",
				message: '<p class="text-center mb-0"><i class="fa fa-spin fa-cog"></i> Welcome to Collector! We are just setting up your dropbox files, <br><div id="dropbox_prog_div"></div><br> Please wait while these are created ready for your use!</p>'
			});

			// do something in the background
			new_dropbox_account(dropbox_dialog);
		});
}
function load_uberMegaFile(link_created){
	$.get(link_created.url.replace("www.","dl."),function(returned_data){
    megaUberJson = JSON.parse(returned_data);
    
    //probable would be good to have a list of things that follow, but for now:
    if(typeof(megaUberJson.keys) == "undefined"){
      encrypt_obj.generate_keys();
    }
    if(typeof(megaUberJson.data.google_script)== "undefined"){
      encrypt_obj.google_script_url();
    }

    $("#public_key").val(megaUberJson.keys.public_key);
    $("#private_key").val(megaUberJson.keys.encrypted_private_key);

		$("#option_Edit").click();
		$("#startup_btn").fadeIn(500);
		$("#startup_btn").on("click",function(){
			startup_dialog.modal("hide");
		});
		// add boosts if not already present
		//////////////////////////////////////
		if(typeof(megaUberJson.boosts) == "undefined"){
			megaUberJson.boosts = {};
		}
		renderItems();
		dbx.filesListFolder({path: '/experiments'})
			.then(function(response) {
			// hack to deal with uneven loading of files
			check_dbx_trialtypes = setInterval(function(){
				if(typeof(dbx_trialtypes_startup) !== "undefined"){
					dbx_trialtypes_startup();
					clearInterval(check_dbx_trialtypes)
				}
			},100);
			})
			.catch(function(error) {
				console.dir("hi 6");
				console.dir(error);
			});
	});
}
function new_dropbox_account(dropbox_dialog){
  $.get("uberMega.json",function(uberMega){
    console.dir(uberMega);
    megaUberJson = uberMega;
    //create more general dropbox update function that queues any dropbox request?
    var these_folders = ["boosts",
                         "experiments",
                         "stimuli",
                         "surveys",
                         "trialtypes"];

    these_folders.forEach(function(this_folder){
      dbx_obj.new_upload({path:"/" + this_folder},
                          function(result){
                            $("#dropbox_prog_div").html("<b>" + this_folder + "</b> created");
                            //do nothing, all is well
                          },
                          function(error){
                            console.dir(this_folder);
                            console.dir("Initial folder causing error");
                            //report_error(error);
                            bootbox.confirm("It looks like you need to confirm the link between your google account and dropbox." +
                                            "If this is the case, please confirm and you will be directed back to dropbox to select" +
                                            "your gmail account to do this with. If not, then this might be an issue that you want" +
                                            "to raise by clicking on the Discuss button in the top right, and then either discuss in" +
                                            "the group forum or on the github issues page",function(result){
                              if(result){
                                force_reauth_dbx(); //risk of infinite loop if this doesn't work :-/
                              }
                            });
                          },
                          "filesCreateFolder");
    dbx_obj.new_upload({path:"/uberMegaFile.json",
                        contents:JSON.stringify(megaUberJson),
                        mode:'overwrite'},
                        function(result){
                          dropbox_dialog.modal('hide');
                          //location.reload();
                          initiate_uberMegaFile();
                        },
                        function(error){
                          console.dir("Initial file causing error");
                          report_error(error);
                        },"filesUpload");

    });
  });
}