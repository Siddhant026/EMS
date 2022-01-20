$(document).ready(function () {

    $('#dob').datetimepicker({
        format: 'L'
    });

    $('#date_of_joining').datetimepicker({
        format: 'L'
    });

    // $("#email").live("change", function () {

    //     // do whatever you need to do
    //     console.log(document.getElementById("email").value);
    //     // you want the element to lose focus immediately
    //     // this is key to get this working.
    //     $('#email').blur();
    //     });
});

function changeName() {
    var object = JSON.parse(document.getElementById("email").value)
    //var map = new Map(document.getElementById("email").value);
    document.getElementById("name").value = object['name'];
}

function changePositions() {
    var department = JSON.parse(document.getElementById("dept_id").value);
    var name = '';
    //console.log(department['id']);
    fetch_position_data(name, department['id']);
}

function fetch_position_data(name = '', dept_id = '') {
    $.ajax({
        url: "/position_filter",
        method: 'GET',
        data: { name: name, dept_id: dept_id },
        dataType: 'json',
        success: function (data) {
            //$("#positiontable > tbody").empty();
            var i = 0;
            for (i; i < data.positions.length; i++) {
                //console.log(data.positions[i].name);
                var content = "";
                //var department;
                //var j = 0;
                // for (j;j<data.departments.length; j++) {
                //     if (data.positions[i].dept_id == data.departments[j].id) {
                //         department = data.departments[j];
                //         break;
                //     }
                // }
                //console.log(department.name);
                content = '<option value="'+ data.positions[i].id +'">'+ data.positions[i].name +'</option>';    
                $("#position_id").append(content);
            }
        }
    })
}