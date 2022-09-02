        <div id="overlay">
            <div class="cv-spinner">
                <span class="spinner"><span></span></span>
            </div>
        </div>

        <div id="preloader">
            <div class="cv-loader">
                <span class="loader"><span></span></span>
                <span class="ml-2 text-warning">Loading ...</span>
            </div>
        </div>

        <footer class="main-footer">
            <div class="footer-left">
                Copyright &copy; <?= date('Y'); ?>
                <!-- <div class="bullet"></div> -->
            </div>
            <div class="footer-right">
                <img src="https://majoo.id/assets/img/main-logo.png" style="float: right; width: 50px;">
            </div>
        </footer>
    </div>
</div>


<script src="<?= base_url('assets/js/stisla.js') ?>"></script>
<script src="<?= base_url('assets/js/scripts.js') ?>"></script>
<script src="<?= base_url('assets/dropify/dist/js/dropify.min.js') ?>"></script>

<script src="<?= base_url('assets/modules/bootstrap/js/bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/modules/nicescroll/jquery.nicescroll.min.js') ?>"></script>

<!--Lib-->
<script src="<?= base_url('assets/swal/sweetalert.min.js') ?>"></script>
<script src="<?= base_url('assets/modules/select2/dist/js/select2.min.js') ?>"></script>
<script src="<?= base_url('assets/summernote/summernote-bs4.min.js') ?>"></script>


<script>
    $('select.form-control.form-control-sm').css({"height": "2rem","padding":" 5px 5px"})
    $('select.form-control.form-control-lg').css({"height": "3rem","padding":" 5px 5px"})

    $("#preloader").fadeIn()

    $(document).ready(function() {
        $("#preloader").fadeOut(300)
        $("#overlay").fadeOut(300)
        $('.description').summernote({
            height: 350,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['picture','link','table','hr']],
                ['misc', ['undo','redo']],
            ]
        })
        $('.js-example-basic-multiple').select2({width:'100%'})
    })

    jQuery(function($){
        $(document).on({
            ajaxStart: function(event, xhr, options) {
                $("#overlay").fadeIn()
            },
            ajaxComplete: function(event, xhr, options) {
                $("#overlay").fadeOut(300)
                if(xhr.hasOwnProperty('responseJSON')) {
                    if(xhr.responseJSON.hasOwnProperty('code')) {
                        if(xhr.responseJSON.code == 401) {
                            if (confirm("Session Expired !\nReload page ?") == true) {
                                location.reload()
                            }
                        }
                    }
                }
            },
        })
    })

    function swallConfirm(param) {
        return swal.fire({
            title: 'Are you sure?',
            text: param.title,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return $.ajax({
                    url: param.url,
                    type: "POST",
                    data: param.data,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response){
                        return response
                    }
                })
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            return result
        }).catch((error) => {
            console.log('error',error)
            swal.fire('Error !', error.statusText, 'error')
        })
    }
    
</script>
</body>
</html>
