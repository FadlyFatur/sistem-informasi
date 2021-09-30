Dropzone.options.mydropzone = {
  paramName:"file",
  maxFilesize:5,//mb
  acceptedFiles : ".png,.jpg,.jpeg,.gif",
  autoProcessQueue : false,
  parallelUploads : 5,
  addRemoveLinks: true,


  init:function(){
    var submitButton = document.querySelector("#submit-all");
    myDropzone = this;

    submitButton.addEventListener('click', function(){
      myDropzone.processQueue();
    });

    this.on('error', function(file, errorMessage) {
      if (file.accepted) {
        var mypreview = document.getElementsByClassName('dz-error');
        mypreview = mypreview[mypreview.length - 1];
        mypreview.classList.toggle('dz-error');
        mypreview.classList.toggle('dz-success');
      }
    });

    this.on("complete", function(){
      if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
      {
        var _this = this;
        _this.removeAllFiles();
      }
      load_images();
    });
  }
};

load_images();

  function load_images()
  {
    $.ajax({
      tyoe:'get',
      url:"/manajemen/galeri/fetch",
      success:function(data)
      {
        $('#uploaded-image').html(data);
      }
    })
  }

  $(document).on('click', '.remove_image', function(){
    var name = $(this).attr('id');
    $.ajax({
      url:"/manajemen/galeri/delete",
      data:{name : name},
      success:function(data){
        load_images();
      }
    })
  });