{{-- session changed modal start hewe --}}

<!-- Button trigger modal -->
</div>



{{-- edit status modal end here --}}
<!-- Modal -->
<div class="modal fade" id="changeSession" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Financial Year</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @php

                $years = App\Models\FinancialYearModel::get();
            @endphp
            <form id="updateSession" method="POST">
              @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="from-label fw-bold">Financial Year</label>
                        <select name="financial_id" class="form-select" id="">
                            <option value="">**Select Financial Year</option>
                            @foreach ($years as $year)
                                <option value="{{ $year->id }}" {{ $year->is_active === 'yes' ? 'selected' : '' }}>
                                    {{ $year->financial_session }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Change Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- session changed modla end here --}}
<script>
    CKEDITOR.replace('editor', {
    height: 300,
    toolbar: [
        { name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print'] },
        { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
        { name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll'] },
        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
        { name: 'styles', items: ['Format', 'Font', 'FontSize'] }
    ]
});

</script>

{{-- logout script section start here --}}
<script class="text/javascript">
    $(document).ready(function() {
        $('#sign_out').on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('logout') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}' // Include the CSRF token
                        },
                        success: function(response) {
                            window.location.href = '{{ route('admin.login') }}';
                        },
                        error: function(error) {
                            console.log('Logout failed:', error);
                        }
                    });

                }
            });
        });
    });
</script>
{{-- logout script section end here --}}

{{-- update financial session --}}
<script type="text/javascript">
$(document).ready(function(){
  $('#updateSession').on('submit',function(e){
    e.preventDefault();
    let formData=$(this).serialize();
    
    let route="{{route('financialYear.update')}}";
    $.ajax({
      headers:{
        'X-CSRF-TOKEN':"{{ csrf_token()}}"
      },
      url:route,
      type:"POST",
      data:formData,
      success:function(response)
      {
        console.log(response);
        if(response.success)
        {
          Swal.fire({
            icon:'success',
            title:'Success',
            text:response.success
          }).then(($result)=>{
            if($result.isConfirmed)
            {
              window.location.reload();
            }
          });
        }
        else{
          Swal.fire({
            icon:'error',
            title:'Error',
            text:response.error
          });
        }
      }
    });
  });
});
</script>


{{-- get client data for update --}}
<script type="text/javascript">
$(document).ready(function() {
    $('#clientTable').on('click', '.editStatus', function(e) {
        e.preventDefault();

        // Get client ID and category ID from data attributes
        let clientId = $(this).data('id');
        let cattId = $(this).data('category-id');

        // Prepare form data as an object
        let formData = {
            clientId: clientId,
            categoryId: cattId,
            _token: "{{ csrf_token() }}" // Include CSRF token for security
        };

        // Get the route URL using Laravel's route helper
        let route = "{{ route('admin.getClientDataForUpdate') }}";

        // Make AJAX POST request
        $.ajax({
            url: route,
            type: "POST",
            data: formData,
            success: function(response) {
                console.log(response); // Log the entire response to see its structure

                // Check if clientDetails exists in the response
                if (response.clientDetails) {

                    $('input[name="clientsStatusUpdateId"]').val(response
                        .clientDetails.id);
                    $('select[name="updateStatusMainCategory"]').val(response
                        .clientDetails.category_id);
                       
                    if (response.clientDetails.sub_category) {
                        $('select[name="clientstatus"]').val(response.clientDetails
                            .sub_category);
                    }
                    $('#editStatusModal').modal('show');
                } else {
                    console.error('Unexpected response structure:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // Log errors if any
            }
        });
    });
    $('#editSubstatusFormForClients').on('submit', function(e) {
    e.preventDefault();
    
    // Serialize form data
    let formData = $(this).serialize();
    
    // Define the route for the request
    let route = "{{ route('admin.UpdateClientStatus') }}";
    
    // Perform the AJAX request
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        url: route,
        type: "POST",
        data: formData,
        success: function(response) {
            // Check if the update was successful
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.success
                }).then(($result) => {
                    // Show the modal and reset the form
                    $('#editStatusModal').modal('show');
                    $('#editSubstatusFormForClients')[0].reset();
                    window.location.reload();  // Reload the page
                });
            } else if (response.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.error
                });
            }
        },
        error: function(xhr) {
            // Check if the response contains validation errors
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;

                // Loop through validation errors and display them
                $.each(errors, function(key, value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: value[0]  // Display the first error message
                    });
                });
            } else {
                // General error handling for unexpected errors
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the status.'
                });
            }
        }
    });
});
});
</script> 
{{-- loader code here --}}
<script>
    // Show loader on page refresh, navigation, or back/forward navigation
    window.addEventListener("beforeunload", function () {
        document.getElementById("ld").style.display = "block";
        document.getElementById("overlay").style.display = "block";
    });

    // Show loader even when navigating back/forward using browser arrows
    window.addEventListener("pageshow", function (event) {
        // Show the loader on back/forward navigation
        if (event.persisted) {
            document.getElementById("ld").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        
        // Hide the loader after the page fully loads
        document.getElementById("ld").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    });
</script>



</div>
{{-- pritn code here --}}
<script>
    function printPart(divId) {
    // Get the element to print
    var printContents = document.getElementById(divId).innerHTML;
    
    // Create a new window for printing
    var printWindow = window.open('', '_blank', 'height=600,width=800');
    
    // Get all the styles from the current document
    var styles = document.head.innerHTML;

    // Write the content into the new window with styles
    printWindow.document.write('<html><head>' + styles + '</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    
    // Close the document to apply the content
    printWindow.document.close();
    
    // Wait for the content to load and then print
    printWindow.onload = function() {
        printWindow.focus(); // Required for some browsers
        printWindow.print();
        printWindow.close();
    };
}

</script>

<script>
    $(function() {
        'use script'

        window.darkMode = function() {
            $('.btn-white').addClass('btn-dark').removeClass('btn-white');
        }

        window.lightMode = function() {
            $('.btn-dark').addClass('btn-white').removeClass('btn-dark');
        }

        var hasMode = Cookies.get('df-mode');
        if (hasMode === 'dark') {
            darkMode();
        } else {
            lightMode();
        }
        $('.select2').select2({
  placeholder: '**Please Select Here..',
  searchInputPlaceholder: 'Search options'
});
    })
</script>
<script type="text/javascript">
    CKEDITOR.replace('editor', {
        allowedContent: true,  // Allow all content by default
        extraAllowedContent: 'div(*){*};table(*){*};tr(*){*};td(*){*}', // Allow all attributes and classes for div, table, tr, td
        toolbar: [{
                name: 'document',
                items: ['Source']  // Source button for viewing HTML
            },
            {
                name: 'basicstyles',
                items: ['Bold', 'Italic']
            },
            {
                name: 'paragraph',
                items: ['NumberedList', 'BulletedList']
            },
            {
                name: 'insert',
                items: ['Image', 'Table']
            },
            {
                name: 'styles',
                items: ['Format']
            }
        ],
        height: 300
    });
</script>

<script src="{{ asset('../../assets/lib/ionicons/ionicons/ionicons.esm.js') }}" type="module"></script>
{{-- <script src="{{ asset('../../assets/lib/select2/js/select2.min.js')}}"></script> --}}
<script src="{{ asset('../../assets/lib/jquery.flot/jquery.flot.js ') }}"></script>
<script src="{{ asset('../../assets/lib/jquery.flot/jquery.flot.stack.js ') }}"></script>
<script src="{{ asset('../../assets/lib/jquery.flot/jquery.flot.resize.js ') }}"></script>
<script src="{{ asset('../../assets/lib/chart.js/Chart.bundle.min.js ') }}"></script>
<script src="{{ asset('../../assets/lib/select2/js/select2.min.js')}}"></script>
<script src="{{ asset('../../assets/lib/jqvmap/jquery.vmap.min.js ') }}"></script>
<script src="{{ asset('../../assets/lib/jqvmap/maps/jquery.vmap.usa.js ') }}"></script>
<script src="{{ asset('../../assets/js/xlsx.full.min.js ') }}"></script>


<script src="{{ asset('../../assets/js/dashforge.sampledata.js') }}"></script>
<script src="{{ asset('../../assets/js/dashboard-one.js') }}"></script>

<script src="{{ asset('../../assets/lib/feather-icons/feather.min.js') }}"></script>


<script src="{{ asset('../../assets/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('../../assets/lib/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('../../assets/lib/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('../../assets/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>

<script src="{{ asset('../../assets/js/dashforge.js') }}"></script>

<!-- append theme customizer -->
<script src="{{ asset('../../assets/lib/js-cookie/js.cookie.js') }}"></script>
<script src="{{ asset('../../assets/js/dashforge.settings.js') }}"></script>
<script src="{{ asset('../../assets/lib/quill/quill.core.js')}}"></script>
<script src="{{ asset('../../assets/lib/quill/quill.min.js')}}"></script>
<script src="{{ asset('../../assets/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('../../assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{ asset('../../assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('../../assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>

<script src="{{ asset('../../assets/js/custom.js') }}"></script>
<script src="{{ asset('../../assets/js/chart.js')}}"></script>
<script src="{{ asset('../../assets/js/datatable.js')}}"></script>
<script src="{{ asset('../../assets/js/options.js')}}"></script>
</body>

</html>
