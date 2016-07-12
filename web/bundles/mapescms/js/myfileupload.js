$().ready(function() {
    if($( "#uploadedfile-dialog-editor" ).length > 0) {
             uploadedfileDialog = $( "#uploadedfile-dialog-editor" ).dialog({
               autoOpen: false,
               show: {
                   effect: "blind",
                   duration: 500
               },
               hide: {
                   effect: "blind",
                   duration: 500
               },                        
               height: 600,
               width: 550,
               modal: true,
               buttons: {
                   "Save": updateUploadedFile,
                   Cancel: function() {
                       uploadedfileDialog.dialog( "close" );
                   }
               },
               open: function() {

               },
               close: function() {
               }
           });
    }
});

function imageOrderObj(fid, seq)
{
    this.fid = fid;
    this.seq = seq;
}

function reorderImage(url, fileEntity, refid) {
    var myImageOrder = [];

    var counter = 1;
    $("#fileupload-" + fileEntity + " .files .template-download").each(function(){

        var myOrder = new imageOrderObj($(this).attr('fileid'), counter);
        myImageOrder.push(myOrder);

        counter++;
    });

    $.ajax({
       url: url,
       data: { fileEntity: fileEntity, refid: refid, imgdata: myImageOrder },
       success: function(data) {
           alert("Image order saved.");
       }
    });
}

function editUploadedFile(fileEntity, fileid)
{
    $.ajax({
       url: '/ajax/get_uploadedfile',
       data: { fileEntity: fileEntity, fileid: fileid },
       success: function(data) {
           //alert(data);
           //var obj = jQuery.parseJSON(data);
            $( "#uploadedfile-dialog-editor .fileid").val(data.fileid);
            $( "#uploadedfile-dialog-editor .file_path").attr('src', data.file_path);
            $( "#uploadedfile-dialog-editor .heading").val(data.heading);
            $( "#uploadedfile-dialog-editor .desc").val(data.desc);
            $( "#uploadedfile-dialog-editor .link").val(data.link);
            //$( "#uploadedfile-dialog-editor .islive").val(data.islive ? 1 : 0);
            $( "#uploadedfile-dialog-editor .islivetd").html('<input type="checkbox" class="islive" ' + (data.islive ? 'checked="checked"' : '')+ '/>');
            uploadedfileDialog.dialog( "open" );
            //$( "#uploadedfile-dialog-editor").reveal();
       }
    });                
}

function updateUploadedFile()
{
    var fileEntity = $( "#uploadedfile-dialog-editor .fileEntity").val();
    var fileid = $( "#uploadedfile-dialog-editor .fileid").val();
    var heading = $( "#uploadedfile-dialog-editor .heading").val();
    var desc = $( "#uploadedfile-dialog-editor .desc").val();
    var link = $( "#uploadedfile-dialog-editor .link").val();
    var islive = $( "#uploadedfile-dialog-editor .islive").is(':checked') ? 1 : 0;
    $.ajax({
       url: '/ajax/update_uploadedfile',
       data: { fileEntity: fileEntity, fileid: fileid, heading: heading, desc: desc, link: link,islive: islive },
       success: function(data) {
            uploadedfileDialog.dialog( "close");
            //$( "#uploadedfile-dialog-editor .close-reveal-modal").click();
       }
    });                  
}
