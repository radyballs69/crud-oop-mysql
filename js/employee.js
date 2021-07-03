var modal, toast;

$(document).ready(function() {
    displayEmployee();
    saveEmployee($('#form_employee'));

    $('#btn_add_employee').on('click', function() {
        resetForm();
        $('#modal_employee .modal-title').text('Add Employee');
    });

    modal = new bootstrap.Modal($('#modal_employee'));
    toast = new bootstrap.Toast($('#alert_toast'));
});

function displayEmployee()
{
    $.post('./employee.php', { type: 'read' })
        .then(res => {
            res = JSON.parse(res);
            if (res.status === 'success') {
                $('#tbl_employee tbody').html(res.data);
            } else {
                notifMsg(res)
            }
        })
        .catch(err => console.log(err));
}

function saveEmployee(form)
{
    form.on('submit', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to continue?')) {
            const data = $(this).serialize();

            $.post('./employee.php', data)
                .then(res => {
                    res = JSON.parse(res);

                    modal.hide();
                    toast.show();
                    notifMsg(res);
                    resetForm();
                    displayEmployee();
                })
                .catch(err => console.log(err));
        } 
    });   
}

function editEmployee(id)
{
    $.post('./employee.php', { id: id, type: 'fetch' })
        .then(res => {
            res = JSON.parse(res);
            if (res.status === 'success') {
                $('#modal_employee .modal-title').text('Edit Employee');
                $('input[name="key"]').val(res.data.employee_number);
                $('#employee_number').val(res.data.employee_number);
                $('#lname').val(res.data.lname);
                $('#fname').val(res.data.fname);
                $('#mname').val(res.data.mname);
                $('#email').val(res.data.email);
                $('#mobile_number').val(res.data.mobile_number);
                modal.show();
            } else {
                notifMsg(res);
            }
        })
        .catch(err => console.log(err));
}

function deleteEmployee(id)
{
    if (confirm('Are you sure you want to delete this record?')) {
        $.post('./employee.php', { id: id, type: 'delete' })
            .then(res => {
                res = JSON.parse(res);

                toast.show();
                notifMsg(res);
                displayEmployee()
            })
            .catch(err => console.log(err));
    }
}

function notifMsg(res)
{
    let bg = res.status === 'success' ? 'bg-danger' : 'bg-success',
        param = res.status === 'success' ? res.status : 'danger',
        toast = $('#alert_toast');

    if ( toast.hasClass(bg) ) toast.removeClass(bg);

    toast.addClass(`bg-${param}`);
    $('#alert_toast .toast-body').text(res.message);
}

function resetForm()
{
    $('#form_employee')[0].reset();
    $('input[name="key"]').val('');
}