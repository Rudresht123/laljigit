<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">User Registration</li>
        </ol>
    </nav>


    @if (session('success'))
        <script>
            var successMessage = '{{ session('success') }}';
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage,
                showConfirmButton: true, // Show the confirm button
                confirmButtonText: 'OK' // Custom text for the button
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            var errorMessage = '{{ session('error') }}';
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: errorMessage,
                showConfirmButton: true, // Show the confirm button
                confirmButtonText: 'OK' // Custom text for the button
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            var validationErrors = '<ul>';
            @foreach ($errors->all() as $error)
                validationErrors += '<li>{{ $error }}</li>';
            @endforeach
            validationErrors += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                html: validationErrors,
                showConfirmButton: true, // Show the confirm button
                confirmButtonText: 'OK' // Custom text for the button
            });
        </script>
    @endif





    {{-- message code end here --}}
    {{-- form-section start here --}}
    {{-- table section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading"><b><i class="fa fa-list"></i> Attoreny :
                                    {{ $attorney->attorneys_name }}</b></div>
                        </div>
                    </div>
                    @if ($category->category_slug === 'trademark')
                        <form id="registrationTrademarkForm" action="{{ route('admin.attorney.addtrademarkformdata') }}" method="POST">
                            @csrf
                            <fieldset class="form-fieldset">
                                <legend>Basic Information</legend>
                                <div class="row p-0 p-md-4">


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Attorney ID<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="attorney_id"
                                            value="{{ $attorney->id }}" readonly placeholder="Attoreny Name..">
                                    </div>

                                    <div class="col-sm-4" hidden>
                                        <label for="" class="form-label">Category ID<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="category_id"
                                            value="{{ $category->id }}" readonly placeholder="Attoreny Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Office<span
                                                class="text-danger">*</span></label>
                                        <select name="office_id" class="form-select" required id="office_id">
                                            <option value="">**Please Office Name...</option>
                                            @foreach ($offices as $office)
                                                <option value="{{ $office->id ? $office->id : '' }}">
                                                    {{ $office->office_name ? $office->office_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Application No.<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('application_no') }}" class="form-control"
                                            required name="application_no" placeholder="Application Number..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Firm Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('file_name') }}" class="form-control" required
                                            name="file_name" placeholder="File Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Trademark Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('trademark_name') }}" class="form-control"
                                            required name="trademark_name" placeholder="Trademark Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">TradeMark Class<span
                                                class="text-danger">*</span></label>
                                        <select name="trademark_class" required class="form-select" id="trademarkclass">
                                            <option value="">**Please Select Trademark Class...</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->class_name ? $class->class_name : '' }}">
                                                    {{ $class->class_name ? $class->class_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Filling Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('filling_date') }}"
                                            class="form-control datepicker" required name="filling_date"
                                            placeholder="Filling Date..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Phone Number<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('phone_no') }}" class="form-control" required
                                            name="phone_no" placeholder="Phone Number..">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email ID<span
                                                class="text-danger">*</span></label>
                                        <input type="email" value="{{ old('email_id') }}" class="form-control"
                                            required name="email_id" placeholder="Please Enter Email Here..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Objected Hearing Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('objected_hearing_date') }}"
                                            class="form-control datepicker" required name="objected_hearing_date"
                                            placeholder="Objected Hearing Date..">
                                    </div>


                                 


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Valid up-To</label>
                                        <input type="text" value="{{ old('valid_up_to') }}"
                                            class="form-control datepicker" name="valid_up_to" required
                                            placeholder="Valid Up to..">
                                    </div>



                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" required class="form-select" id="">
                                            <option value="">**Please Select Status</option>
                                            @foreach ($statuss as $status)
                                                <option class="capitalize" data-slug="{{ $status->slug ?? '' }}"
                                                    data-id="{{ $status->id }}"
                                                    value="{{ $status->id ? $status->id : '' }}">
                                                    {{ $status->status_name ? $status->status_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Sub-Status<span
                                                class="text-danger">*</span></label>
                                        <select name="sub_status" id="sub-status" required class="form-select "
                                            id="">
                                        </select>
                                    </div>

                                    {{-- conditional components start here --}}

                                    {{-- opposed no --}}
                                    <div class="col-sm-4" id="opposed_no" style="display: none;">
                                        <label for="" class="form-label">Opposed No..</label>
                                        <input type="text" value="" class="form-control" name="opposed_no"
                                            placeholder="Please Enter Oppose No..">
                                    </div>
                                    {{-- opposed no --}}
                                    
                                    <!--opposition hearing data-->
                                       <div class="col-sm-4" id="opposition_hearing_date" style="display: none;">
                                        <label for="" class="form-label">Opposition Hearing Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('opposition_hearing_date') }}"
                                            name="opposition_hearing_date" class="form-control datepicker"
                                            placeholder="Opposition Hearing Date..">
                                    </div>
                                    <!--opposition hearing date end here-->

                                     {{-- rectification no --}}
                                     <div class="col-sm-4" id="rectification_no" style="display: none;">
                                        <label for="" class="form-label">Rectification No..</label>
                                        <input type="text"  value="" class="form-control"
                                            name="rectification_no" placeholder="Please Enter Rectification No..">
                                    </div>
                                    {{-- rectification no --}}

                                    {{-- opponent applicant --}}
                                    {{-- Opponent/Applicant --}}
                                    <div class="col-sm-4" id="opponent_applicant" style="display: none;">
                                        <label for="opponent_applicant_name" class="form-label">Opponent/Applicant</label>
                                        <select id="opp_app_name" name="opponent_applicant"
                                            class="form-select">
                                            <option value="">**Please Select..</option>
                                            <option value="Opponent">Opponent</option>
                                            <option value="Applicant">Applicant</option>
                                        </select>
                                    </div>
                                    {{-- End Opponent/Applicant --}}

                                    {{-- opponent applicant --}}

                                    {{-- applicant --}}
                                    <div class="col-sm-4" id="applicant_name" style="display: none;">
                                        <label for="" class="form-label">Applicant Name</label>
                                        <input type="text" value="" class="form-control" name="applicant_name"
                                            placeholder="Please Enter Applicant Name..">
                                    </div>
                                    <div class="col-sm-4" id="applicant_code" style="display: none;">
                                        <label for="" class="form-label">Applicant Code..</label>
                                        <input type="text" value="" class="form-control" name="applicant_code"
                                            placeholder="Please Enter Applicant Code..">
                                    </div>
                                    {{-- applicant --}}

                                    {{-- opponent --}}
                                    <div class="col-sm-4" id="opponent_name" style="display: none;">
                                        <label for="" class="form-label">Opponent Name</label>
                                        <input type="text" value="" class="form-control" name="opponent_name"
                                            placeholder="Please Enter Opponent Name..">
                                    </div>
                                    <div class="col-sm-4" id="opponent_code" style="display: none;">
                                        <label for="" class="form-label">Opponent Code..</label>
                                        <input type="text"  value="" class="form-control"
                                            name="opponent_code" placeholder="Please Enter Opponent Code..">
                                    </div>
                                    {{-- opponent --}}
                                    
                                    
                                    
                                    <!--evidence last date-->
                                     <div class="col-sm-4" id="evidence_last_date" style="display:none;">
                                        <label for="" class="form-label">Evidence Last Date</label>
                                        <input type="text" name="evidence_last_date" value="{{ old('evidence_last_date') }}" class="form-control datepicker"
                                            placeholder="Please Enter Evidence last Date...">
                                    </div>
                                     <!--evidence last date-->
                                    
                                    
                                    {{-- examination report --}}
                                    <div class="col-sm-4" id="examination_report_submitted" style="display: none;">
                                        <label for="" class="form-label">Examination Report Submitted</label>
                                        <select name="examination_report_submitted" class="form-select" id="">
                                            <option value="">**Please Select Examination Report Status..</option>
                                            <option value="yes">Yes</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                    {{-- examination report --}}

                                    {{-- hearing date --}}
                                    <div class="col-sm-4" id="hearing_date" style="display: none;">
                                        <label for="" class="form-label">Hearing Date..</label>
                                        <input type="text"  value=""
                                            class="form-control datepicker" name="hearing_date"
                                            placeholder="Please Enter Hearing Date..">
                                    </div>

                                    <div class="col-sm-4" id="post_hearing_remarks" style="display: none;">
                                        <label for="" class="form-label">Post Hearing Remarks..</label>
                                        <textarea  class="form-control" name="post_hearing_remarks" id="" cols="1" rows="1"></textarea>
                                    </div>
                                    {{-- hearing date --}}

                                   

                                    {{-- conditional components start end --}}

                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Trademark Sub Category<span
                                                class="text-danger">*</span></label>
                                        <select name="sub_category" id="sub-category" required class="form-select select2"
                                            id="">
                                            <option value="">**Please Select Sub-Category</option>
                                            @foreach ($subcategory as $subcat)
                                                <option class="capitalize" value="{{ $subcat->id ? $subcat->id : '' }}">
                                                    {{ $subcat->subcategory ? $subcat->subcategory : '' }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                            </fieldset>



                            <fieldset class="form-fieldset mt-4">
                                <legend>Consultant Information</legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Consultant Name<span
                                                class="text-danger">*</span></label>
                                        <select name="consultant" required class="form-select" id="consultant">
                                            <option value="">**Please Select Consultant Name..</option>
                                            @foreach ($consultant as $consultant)
                                                <option class="capitalize" value="{{ $consultant->id ?? '' }}">
                                                    {{ $consultant->consultant_name ?? '' }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Deal With<span
                                                class="text-danger">*</span></label>

                                        <select name="deal_with" required class="form-select" id="deal_with">
                                            <option value="">**Please Select Dealler Name..</option>
                                            @foreach ($dealWith as $dealw)
                                                <option class="capitalize" value="{{ $dealw->id ?? '' }}">{{ $dealw->dealler_name ?? '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Filed By<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" readonly required
                                            value="{{ $attorney->attorneys_name ? $attorney->attorneys_name : '' }}"
                                            name="filed_by" placeholder="Please Enter Filed Name..">
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="" class="form-label">Remarks<span class="text-danger">*</span> </label>
                                        <select name="remarks" required class="form-select select2" id="remarks">
                                            <option value="">**Please Select Remarks</option>
                                            @foreach ($remarks as $remark)
                                                <option class="capitalize" value="{{ $remark->id ? $remark->id : '' }}">
                                                    {{ $remark->remarks ? $remark->remarks : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <label for="" class="form-label">Client Remarks<span class="text-danger">*</span> </label>
                                        <select name="client_remarks" required class="form-control select2 " id="client_remarks">
                                            <option value="">**Please Select Remarks</option>
                                            @foreach ($clientRemarks as $cleintRemark)
                                                <option class="capitalize" value="{{ $cleintRemark->id ? $cleintRemark->id : '' }}">
                                                    {{ $cleintRemark->client_remarks ? $cleintRemark->client_remarks : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            {{-- communication information fieldset --}}
                            <fieldset class="form-fieldset mt-4">
                                <legend>Client Communication Information</legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">IP Field <span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{ $category->category_name }}" name="ip_field"
                                            readonly class="form-control" placeholder="Name Of IP Field...">
                                    </div>
                                   
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email Recived Date</label>
                                        <input type="text" value="{{ old('email_recived_date') }}"
                                            class="form-control datepicker" name="mail_recived_date"
                                            placeholder="Email Recived Date 2..">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email Recived Date 2</label>
                                        <input type="text" value="{{ old('email_recived_date_2') }}"
                                            class="form-control datepicker" name="mail_recived_date_2"
                                            placeholder="Email Recived Date 2..">
                                    </div>

                                    <div class="col-sm-8">
                                        <label for="" class="form-label">Email Remarks</label>
                                        <textarea class="form-control" name="email_remarks" placeholder="Please Enter Client Email Remarks..."
                                            id="" cols="1" rows="1">{{old('email_remarks')}}</textarea>

                                    </div>

                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Client Communication</label>
                                        <textarea class="form-control" name="client_communication"
                                            placeholder="Please Enter Client Communication Feedback Here..." id="" cols="2" rows="2">{{old('client_communication')}}</textarea>
                                    </div>

                                </div>
                            </fieldset>
                            <div class="row mt-3">
                                <div class="col-lg-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="confirmCheck">
                                        <label class="form-check-label fs-12" for="flexCheckDefault">
                                            <span class="text-danger">*</span> Please complete the form and click on the checkbox to confirm your submission.
                                        </label>
                                      </div>
                                </div>
                                <div class="col-sm-6  d-flex justify-content-end">
                                    <input type="reset" value="Reset" class="btn me-2 btn-danger px-3 py-2">
                                    <input type="submit" value="Submit" id="submitRegistrationForm" class="btn btn-primary px-3 py-2">
                                </div>
                            </div>
                            </div>
                        </form>
                    @elseif($category->category_slug === 'copyright')
                        <div class="row">
                            <div class="col-sm-6 mx-auto text-center">
                                <h3>In working</h3>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- form-section start here --}}



    {{-- script section statr here --}}
    <script type="text/javascript">
        // code for geting substatus
        $(document).ready(function () {
        // Bind change event to #status
        $('#status').on('change', function (e) {
            e.preventDefault();
            let statusId = $(this).val();
            let route = "{{ route('getsubstatus', ':id') }}".replace(':id', statusId);

            // Call the common function to fetch and populate substatus
            populateSubstatus(route, null); // Pass `null` if no slug is provided
        });
    });
    </script>
    {{-- script section statr here --}}

    {{-- script for the validations --}}
    <script type="text/javascript">
    document.getElementById("registrationTrademarkForm").addEventListener("submit", function (event) {
        const selectBoxIds = ["office_id", "trademarkclass", "status",'sub-status','sub-category','consultant','deal_with','remarks','client_remarks']; 
        if (!validateSelectBoxes(selectBoxIds)) {
            event.preventDefault(); 
        }
    });

    $(document).ready(function () {
    const checkbox = $('#confirmCheck');
    const trademarkFormSubmit = $('#submitRegistrationForm');
    trademarkFormSubmit.prop('disabled', !checkbox.is(':checked'));
    checkbox.on('change', function () {
        trademarkFormSubmit.prop('disabled', !this.checked);
    });
});

    </script>

    {{-- dynamic options code here on change status much more --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // Event listener for #status dropdown
            $('#status').on('change', function(e) {
                e.preventDefault();
                let statusSlug = $(this).find(':selected').data('slug');
                getOpptionsforStatus(statusSlug);
            });

            // Event listener for #opponent_applicant_name dropdown
            $('#opp_app_name').on('change', function(e) {
                e.preventDefault();
                let statusSlug = $('#status').find(':selected').data('slug'); // Fixed missing '#' in selector
                const getvalue = $(this).val();
                getOpponentApplicantNameNumber(getvalue, statusSlug);
            });
        });
    </script>
    {{-- dynamic options code here on change status much more --}}

    {{-- main section end here --}}
@endsection
