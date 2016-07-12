        var totalFormFields = 0;
        var FormFields = [];

        $().ready(function() {
                var $formFieldInput = $('.customformme');
	        $formFieldInput.parent().append('<div class="nav-scrollable"><ul id="form-fields-container"></ul><div class="nav-add-another"><a href="#" class="add-icon" onClick="resetFormFieldEditor(); openFormFieldEditor();return false">ADD ANOTHER</a></div><div class="clearAll"></div></div>');
                $formFieldInput.hide();
                
                if ($formFieldInput.val() != '') {

                        FormFields = $.parseJSON($formFieldInput.val());
                        totalFormFields = FormFields.length;
                        for (var i = 0; i < FormFields.length; i++) {

                                quickCreateFormField(i);
                        }
                }

                $("#form-fields-container").sortable({
                    stop: function(event, ui){saveFormFields();}
                });    


        });
        
        function FormFieldObj(title, type, options, help, manda) {
            this.title = title;
            this.type = type;
            this.options = options;
            this.help = help;
            this.manda = manda;
        }
        
        function printFormField(id)
        {
            var FormFieldItem = FormFields[id];

            var title = FormFieldItem.title;
            var type = FormFieldItem.type;
            var options = FormFieldItem.options;
            var help = FormFieldItem.help;
            var manda = FormFieldItem.manda;
            
            var writeString = "";
            
            if(title != "")
                            writeString += "<b>" + title + "</b>";
                    else
                            writeString += "[No Label Supplied]";

            if(manda == "1"){
                  writeString += "<sup style='color: red'>*</sup>";
            }

            writeString += "<br />";

            switch(type)
            {
                    case "text": writeString += "<input type='text' style='width: 120px' />";
                            break;
                    case "textbox": writeString += "<textarea type='text' style='width: 120px; height: 40px' ></textarea>";
                            break;
                    case "select":
                            var fullArray = options.split("\n");
                            writeString += "<select>";
                            for(var i = 0; i < fullArray.length; i++)
                            {
                                    if(fullArray[i] != "")
                                            writeString += "<option>" + fullArray[i] + "</option>";
                            }
                            writeString += "</select>";
                            break;
                    case "radio":
                            var fullArray = options.split("\n");
                            for(var i = 0; i < fullArray.length; i++)
                            {
                                    if(fullArray[i] != "")
                                            writeString += "<input type='radio' /> " + fullArray[i] + "<br />";
                            }
                            break;
                    case "checkbox":
                            var fullArray = options.split("\n");
                            for(var i = 0; i < fullArray.length; i++)
                            {
                                    if(fullArray[i] != "")
                                            writeString += "<input type='checkbox' /> " + fullArray[i] + "<br />";
                            }
                            break;
                    case "image":
                            writeString += "<input type='file' />";
                            break;
            }

            writeString += "<br /><i>" + help + "</i>";

            writeString += "<div class='clearAll'></div>";

            return writeString;
        }
            
        function quickCreateFormField(id)
        {
            var FormFieldItem = FormFields[id];
            var data_id = id;

            /*var title = FormFieldItem.title;
            var type = FormFieldItem.type;
            var options = FormFieldItem.options;
            var help = FormFieldItem.help;
            var manda = FormFieldItem.manda;*/

            var writeString = '<li class="top-nav-item top-nav-show-1" data-id="' + data_id + '"><div class="controls"><a href="#" class="edit-icon" title="Edit" onClick="editFormFieldInEditor($(this).closest(\'li\').attr(\'data-id\')); openFormFieldEditor(); return false"></a> <a href="#" class="delete-icon" onClick="deleteFormField($(this).closest(\'li\').attr(\'data-id\')); return false"></a></div><div class="promo-contents"></div><div class="clearAll"></div></li>';
            $("#form-fields-container").append(writeString);
            

            /* WRITE CONTENTS */
            writeString = printFormField(data_id);
            
            $("#form-fields-container li[data-id='" + data_id + "'] .promo-contents").html(writeString);

        }        
        
        function resetFormFieldEditor()
        {
                $("#form-field-editor input[type=text]").val("");
                $("#form-field-editor-id").val("");
                $("#form-field-editor-type").val("text");
                $("#form-field-editor-options").val("");
                $("#form-field-editor-manda").prop('checked', false);
        }        
        
        function editFormFieldInEditor(id)
        {
                var FormFieldItem = FormFields[id];

                $("#form-field-editor-id").val(id);
                $("#form-field-editor-title").val(FormFieldItem.title);
                $("#form-field-editor-type").val(FormFieldItem.type);
                $("#form-field-editor-options").val(FormFieldItem.options);
                $("#form-field-editor-help").val(FormFieldItem.help);
				
                if(FormFieldItem.manda == "1") {
                    $("#form-field-editor-manda").prop('checked', true);
                }else{
                    $("#form-field-editor-manda").prop('checked', false);
                }
                    
        }        
        
        function openFormFieldEditor()
        {
                formFieldEditorDialog = $("#form-field-editor" ).dialog({
                  autoOpen: false,
                  show: {
                      effect: "blind",
                      duration: 500
                  },
                  hide: {
                      effect: "blind",
                      duration: 500
                  },                        
                  height: 350,
                  width: 600,
                  modal: true,
                  buttons: {
                      "Save": function() {
                          if($("#form-field-editor-id").val() == ""){
                              newFormField();
                          }else{
                              updateFormField($("#form-field-editor-id").val());
                          }
                          formFieldEditorDialog.dialog( "close" );
                      },
                      Cancel: function() {
                          formFieldEditorDialog.dialog( "close" );
                      }
                  },
                  open: function() {

                  },
                  close: function() {
					  //$(this).dialog('destroy').remove();
                  }
               });

               formFieldEditorDialog.dialog( "open" );             
        }
        
        function newFormField()
        {
                var title = $("#form-field-editor-title").val();
                var type = $("#form-field-editor-type").val();
                var options = $("#form-field-editor-options").val();
                var help = $("#form-field-editor-help").val();
                var manda = "";
                if($("#form-field-editor-manda").is(":checked"))
                    manda = "1";

                var FormFieldItem = new FormFieldObj(title, type, options, help, manda);
                FormFields.push(FormFieldItem);


                totalFormFields = FormFields.length;
                var data_id = totalFormFields - 1;

                var writeString = '<li class="top-nav-item top-nav-show-1" data-id="' + data_id + '"><div class="controls"><a href="#" class="edit-icon" title="Edit" onClick="editFormFieldInEditor($(this).closest(\'li\').attr(\'data-id\')); openFormFieldEditor(); return false"></a> <a href="#" class="delete-icon" onClick="deleteFormField($(this).closest(\'li\').attr(\'data-id\')); return false"></a></div><div class="promo-contents"></div><div class="clearAll"></div></li>';
                $("#form-fields-container").append(writeString);

                /* WRITE CONTENTS */
                writeString = printFormField(data_id);
                
                $("#form-fields-container li[data-id='" + data_id + "'] .promo-contents").html(writeString);

                saveFormFields();

        } 
        
        function updateFormField(id)
        {
                var data_id = id;
                
                var FormFieldItem = FormFields[data_id];
                var title = $("#form-field-editor-title").val();
                var type = $("#form-field-editor-type").val();
                var options = $("#form-field-editor-options").val();
                var help = $("#form-field-editor-help").val();
                var manda = "";
                if($("#form-field-editor-manda").is(":checked"))
                    manda = "1";

                FormFieldItem.title = title;
                FormFieldItem.type = type;
                FormFieldItem.options = options;
                FormFieldItem.help = help;
                FormFieldItem.manda = manda;

                /* WRITE CONTENTS */
                var writeString = printFormField(data_id);
                $("#form-fields-container li[data-id='" + data_id + "'] .promo-contents").html(writeString);

                saveFormFields();

        }        
        
        function deleteFormField(id)
        {

                if(confirm("Are you sure you want to remove this item?"))
                {
                        FormFields.splice(id, 1);
                        $("#form-fields-container li[data-id='" + id + "']").remove();


                        if(id < (totalFormFields - 1)){
                            $("#form-fields-container li").each(function(){
                                var data_id = $(this).attr('data-id');
                                if(data_id > id){
                                    $(this).attr('data-id', data_id - 1);
                                }

                            })
                        }
                        totalFormFields--;

                        saveFormFields();
                }
        }        
        
        function saveFormFields()
        {
                var myFormFields = [];
                $("#form-fields-container li.top-nav-item").each(function(){
                    var id = $(this).attr('data-id');
                    if(id != undefined){
                        var FormFieldItem = new FormFieldObj(FormFields[id].title, FormFields[id].type, FormFields[id].options, FormFields[id].help, FormFields[id].manda);
                        myFormFields.push(FormFieldItem);
                    }
                })

                var myJSONText = JSON.stringify(myFormFields, replacer);

                $(".customformme").val(myJSONText);
        }
