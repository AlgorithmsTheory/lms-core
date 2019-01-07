$(document).ready(function(){

    $('#1_section').collapse({ parent: '#accordion', toggle: true });
    $('#2_section').collapse({ parent: '#accordion', toggle: true  });
    $('#3_section').collapse({ parent: '#accordion', toggle: true  });
    $('#4_section').collapse({ parent: '#accordion', toggle: true  });
    $("#1_section").collapse('show');
    $("#1_section_link").click(function(){
        $("#1_section").collapse('show');
        $("#2_section").collapse('hide');
        $("#3_section").collapse('hide');
        $("#4_section").collapse('hide');
    });
    $("#2_section_link").click(function(){
        $("#2_section").collapse('show');
        $("#1_section").collapse('hide');
        $("#3_section").collapse('hide');
        $("#4_section").collapse('hide');
    });
    $("#3_section_link").click(function(){
        $("#3_section").collapse('show');
        $("#1_section").collapse('hide');
        $("#2_section").collapse('hide');
        $("#4_section").collapse('hide');
    });
    $("#4_section_link").click(function(){
        $("#4_section").collapse('show');
        $("#1_section").collapse('hide');
        $("#2_section").collapse('hide');
        $("#3_section").collapse('hide');
    });
});