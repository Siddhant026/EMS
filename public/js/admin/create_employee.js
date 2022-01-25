$(document).ready(function () {

    $('#dob').datetimepicker({
        format: 'L'
    });

    $('#date_of_joining').datetimepicker({
        format: 'L'
    });
});

function changeName() {
    var object = JSON.parse(document.getElementById("email").value)
    document.getElementById("name").value = object['name'];
}

function changePositions() {
    var department = JSON.parse(document.getElementById("department").value); 
    var name = '';
    fetch_position_data(name, department['id']);
}

function fetch_position_data(name = '', dept_id = '') {
    $.ajax({
        url: "/position_filter",
        method: 'GET',
        data: { name: name, dept_id: dept_id },
        dataType: 'json',
        success: function (data) {
            var i = 0;
            for (i; i < data.positions.length; i++) {
                var content = "";
                content = '<option value="'+ data.positions[i].id +'">'+ data.positions[i].name +'</option>';    
                $("#position").append(content);
            }
        }
    })
}