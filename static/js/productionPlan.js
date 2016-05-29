$(document).ready(function() {
    function addPlan (data, tr) {
        $.ajax({
            url: 'ajax_handlers/addPlan.php',
            type: 'POST',
            data: data,
            success: function(jsondata) {
                var data = JSON.parse(jsondata);
                var modelName = $('option[value = "' + data.id + '"]').html();

                if (data.status == "200") {
                    $('.report-table__form-row').before("<tr>" +
                        "<td><a href = 'listOfModels.php?id=" + data.id + "&" + modelName + "'>"  + modelName + "</a></td>" +
                        "<td>" + data.count + "</td>" +
                        "<td>" + data.date + "</td>" +
                        "<td></td>"+
                        "</tr>"
                    )
                }
                else {
                    $('.center-block').append('<div class="errors>' + data.error + '</div>')
                }
            },
        });
    }

    function validateCount( count, required ) {
        required = required || true;
        if ( required && !count) {
            $('.center-block').append('<div class="errors"> Вы не указали количество </div>')
            return false;
        }
        if( count <= 0) {
            $('.center-block').append('<div class="errors"> Число должно быть положительным </div>')
            return false;
        }
        return true;
    }

    function validateDate( date, required ) {
        required = required || true;
        if( required && !date ) {
            $('.center-block').append('<div class="errors"> Вы не указали дату сборки </div>')
            return false;
        }
        var now = new Date();
        var today = new Date(now.getFullYear(), now.getMonth(), now.getDate()).valueOf()
        var newDate = new Date(date).valueOf();
        
        if (newDate < today ) {
            $('.center-block').append('<div class="errors"> Указана прошедшая дата </div>')
            return false;
        }
        return true;
    }
    
    $('.add-btn').click(function (event) {
        $.ajax({
            url: 'ajax_handlers/getModelList.php',
            success: function(jsondata){
                var data = JSON.parse(jsondata);
                var selector = "<select name='id_m'>";

                data.forEach(function(item, i, data){
                    selector += ("<option value='"+ item.Id_M + "'>" + item.Name + "</option>");
                });
                selector += "</select>";
                
                $(".report-table").append("<tr class='report-table__form-row'>" +
                    "<td>" + selector + "</td>" +
                    "<td><input type=number name='count' required min='0' max='9999999'></td>" +
                    "<td><input type=date name='date' required></td>"+
                    "<td><form class='add-plan-form'><button type='submit' class='btn btn-success'><span class='glyphicon glyphicon-plus' ></span></button></form></td>"+
                    "</tr>");
                
                $(".add-btn").hide();

                $('.add-plan-form').submit( function(event) {
                    event.preventDefault();
                    $('.errors').remove();
                    var row = $(this).closest("tr");
                    var id = row.find("select[name='id_m']").val();
                    var count = row.find("input[name='count']").val();
                    var date = row.find("input[name='date']").val();

                    if( validateCount(count) && validateDate(date) ) {
                        var data = { 'id': id, 'count': count, 'date': date };
                        addPlan(data, row);
                        return false;
                    }
                    return;
                });
            },
            error: function(jsondata)  {
                console.log("error during getting list of Models");
            }
        });
    });

});