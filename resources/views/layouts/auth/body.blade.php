
@include('layouts.auth.header')
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('layouts.auth.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.auth.topbar')

                @yield('content')

            </div>
            <!-- End of Main Content -->



            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; www.laundrybangla.com</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('template/js/poppers.min.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery/juery.3.1.6.js') }}"></script>
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('template/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Data tble scripts -->
    <script src="{{ asset('template/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('template/js/demo/chart-pie-demo.js') }}"></script>

     <!-- Data table plugins -->
     <script src="{{ asset('template/vendor/datatables/jquery.dataTables.min.js') }}"></script>
     <script src="{{ asset('template/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

     <!-- Data tble scripts -->
     <script src="{{ asset('template/js/demo/datatables-demo.js') }}"></script>

     <script src ="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
     <script src ="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>


     {{-- Toastr js  --}}
     <script src="{{ asset('template/js/toastr.js') }}"></script>
     {{-- Date Range Peacker Js  --}}
     <script type="text/javascript" src="{{ asset('template/js/moment.js') }}"></script>
     <script type="text/javascript" src="{{ asset('template/js/daterangepeacker.js') }}"></script>
     <!-- include libraries(jQuery, bootstrap) -->
     <script src="{{ asset('template/js/tinymc.min.js') }}"></script>
     <script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
     {{-- <script src="{{ asset('template/js/cheditor.js') }}"></script> --}}

     {{-- Sweet llert 2 js  --}}
    <script src="{{ asset('template/js/sweetalert2.all.min.js') }}"></script>


    <script type="text/javascript">
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            });

        ClassicEditor
        .create( document.querySelector( '#editor2' ) )
            .catch( error => {
                console.error( error );
            } );

        $('input.date').daterangepicker({
            locale: {
                    format: 'YYYY-MM-DD',

            },
            autoUpdateInput: false,
            singleDatePicker: true,
            showDropdowns: true,
        });
        $('input.date').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });

        $('input.date').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });


        $('.dataTableClass').dataTable({
            "bPaginate": true,
            "bFilter": true,
            "bInfo": true
        });

        $('.reportdataTableClass').DataTable({
            dom: 'Bfrt',
            buttons: [
                        'csv'
            ],
        });

        $('.datatable').dataTable( {
            "bPaginate": false,
            "bFilter": false,
            "bInfo": false
        });



        $(document).ready(function() {
            @if(Session::has('success'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
                toastr.success("{{ session('success') }}");
            @endif

            @if(Session::has('error'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
                toastr.error("{{ session('error') }}");
            @endif

            @if(Session::has('info'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
                toastr.info("{{ session('info') }}");
            @endif

            @if(Session::has('warning'))
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }
                toastr.warning("{{ session('warning') }}");
            @endif
        });


        $(document).on("click", ".show_confirm", function() {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            Swal.fire({
                    title: `Are you sure ?`
                    , text: "If you delete this, It will be gone forever."
                    , icon: "question"
                        // ,position:'top'
                    , background: 'rgba(255, 255, 255,1)'
                    , showCancelButton: true
                    , confirmButtonColor: '#d33'
                    , cancelButtonColor: '#06E66F'
                    , confirmButtonText: ' Delete '
                    , iconColor: '#d33'
                , })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    } else {
                        Swal.fire(
                            'Cancelled'
                            , 'Your imaginary process is safe'
                            , 'success'
                        )
                    }
                });
        });

        $(document).on("click", ".show_confirm_status", function() {
            var form = $(this).closest("form");
            var name = $(this).data("name");
            event.preventDefault();
            Swal.fire({
                    title: `Are you sure to Change the Status ?`
                    , text: "If you Change this, The Status will Change."
                    , icon: "question"
                        // ,position:'top'
                    , background: 'rgba(255, 255, 255,1)'
                    , showCancelButton: true
                    , confirmButtonColor: '#d33'
                    , cancelButtonColor: '#06E66F'
                    , confirmButtonText: ' Change '
                    , iconColor: '#d33'
                , })
                .then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    } else {
                        Swal.fire(
                            'Cancelled'
                            , 'Your imaginary file is safe'
                            , 'success'
                        )
                    }
                });
        });
    </script>

@yield('script')
    </body>
</html>
