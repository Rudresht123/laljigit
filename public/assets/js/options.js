function getOpptionsforStatus(slug) {
    // Reset visibility of all elements
   
    $('#opposed_no, #rectification_no, #opponent_applicant, #applicant_name, #applicant_code, #opponent_name, #opponent_code,#examination_report_submitted,#hearing_date,#opposition_hearing_date,#evidence_last_date,#post_hearing_remarks').css('display', 'none');

    // Adjust visibility based on slug
    if (slug === 'opposed') {
        $('#opposed_no').css('display', 'block');
        $('#opponent_applicant').css('display', 'block');
        $('#opposition_hearing_date').css('display', 'block');
        $('#evidence_last_date').css('display', 'block');
    } else if (slug === 'rectification_field') {
        $('#rectification_no').css('display', 'block');
        $('#opponent_applicant').css('display', 'block');
        $('#opposition_hearing_date').css('display', 'block');
    }

    // Bind event listener to #opp_app_name only for relevant slugs
    if (slug === 'opposed' || slug === 'rectification_field') {
        $('#opp_app_name').off('change').on('change', function () {
            const getvalue = $(this).val();
            getOpponentApplicantNameNumber(getvalue, slug);
        });
    }
    else if(slug === 'objected'){
        $('#sub-status').off('change').on('change', function () {
            let substatusSlug = $(this).find(':selected').data('slug');
            subStatusHearingDateExaminationReport(slug,substatusSlug);
        });   
    }
    else {
        $('#opp_app_name').off('change');
    }
}

function getOpponentApplicantNameNumber(getvalue, slug) {
    if (slug === 'opposed' || slug === 'rectification_field') {
        if (getvalue === 'Opponent') {
            $('#applicant_name, #applicant_code').css('display', 'block');
            $('#opponent_name, #opponent_code').css('display', 'none');
        } else if (getvalue === 'Applicant') {
            $('#opponent_name, #opponent_code').css('display', 'block');
            $('#applicant_name, #applicant_code').css('display', 'none');
        } else {
            // Hide all fields for invalid values
            $('#applicant_name, #applicant_code, #opponent_name, #opponent_code').css('display', 'none');
        }
    } else {
        // Hide all fields for slugs other than "opposed" and "rectification_field"
        $('#applicant_name, #applicant_code, #opponent_name, #opponent_code').css('display', 'none');
    }
}
function subStatusHearingDateExaminationReport(slug,substatusSlug) {

    if (slug !== 'objected') {
        $('#examination_report_submitted, #hearing_date,#post_hearing_remarks').css('display', 'none');
        return;
    }

    // Reset visibility
    $('#examination_report_submitted, #hearing_date,#post_hearing_remarks').css('display', 'none');

    // Handle different values of getvalue
    switch (substatusSlug) {
        case 'examination_report':
            $('#examination_report_submitted').css('display', 'block');
            break;

        case 'show_cause_hearing':
            $('#hearing_date').css('display', 'block');
            $('#post_hearing_remarks').css('display', 'block');
            break;

        default:
            break;
    }
}

