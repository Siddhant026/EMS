$(document).ready(function () {

    $('#departmenttable').DataTable();
});

function delete_dept(id) {
    //console.log("delete user "+id);
    if (confirm('Are you sure you want to DELETE ?')) {
        $.ajax({
            url: "/admin/sys_mgnt/dept/"+id,
            method: 'DELETE',
            data: { _token: token, id: id },
            dataType: 'json',
            success: function (data) {
                location.reload();
                // location.replace("/admin/user_mgnt");
            }
        });
        location.reload();
        //fetch_user_data();
        //location.replace("/admin/user_mgnt");
    }
}