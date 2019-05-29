//:::::::::::::::::::::>> CanCyber Custom function
$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
    }
});
function deleteConfirm(url, redirect){
	swal({
							title: "Are you sure you wan to delete?",
							text: "",
							type: "warning",
							showCancelButton: true,
							cancelButtonClass: "btn-default",
							confirmButtonClass: "btn-warning",
							confirmButtonText: "Yes!",
							closeOnConfirm: false
						},
						function(){
							// swal({
							// 	title: "Deleted!",
							// 	text: "Data has been deleted.",
							// 	type: "success",
							// 	confirmButtonClass: "btn-success"
							// });
							//alert('deleted');

							$.ajax({
					        url: url,
					        type: 'DELETE',
					        data: {},
					        success: function( response ) {
					            if ( response.status === 'success' ) {
					            	window.location.replace(redirect);
					                //toastr.success( response.msg );
					                // setInterval(function() {
					                //     window.location(redirect);
					                // }, 5900);
					            }
					        },
					        error: function( response ) {
					            if ( response.status === 422 ) {
					                toastr.error('Cannot delete the category');
					            }
					        }
					    });
	});
}

function updatePublish(url, id){
	 active = $('#active-'+id);
	 publish = 0;
	 var noAttr = active.attr('checked');
	 if(typeof noAttr == 'undefined'){
	  publish = 1;
	 }
	 $.ajax({
				        url: url,
				        method: 'POST',
				        data: {id:id, publish:publish },
				        success: function( response ) {
				            if ( response.status === 'success' ) {
				            	swal("Nice!", response.msg ,"success");
				            	if(publish == 1){
	                              active.attr('checked', True);
				            	}else{
				            		active.removeAttr('checked');
				            	}
				            }else{
				            	swal("Error!", "Sorry there is an error happens. " ,"error");
				            }
				        },
				        error: function( response ) {
				           swal("Error!", "Sorry there is an error happens. " ,"error");
				        }
		    });
       

}
function publish_on_off(){
	var obj	  = $("#publish");
	var value = obj.val();
	if(value == 0){
		obj.val(1);
		obj.attr('checked');
	}else{
		obj.val(0);
		obj.removeAttr('checked');
	}
}

function booleanForm(id){
	val 	= $('#'+id).val();
	if(val == 0){
		$('#'+id).val(1);
	}else{
		$('#'+id).val(0);
	}
}

/* ==========================================================================
	Datepicker
	========================================================================== */
$(document).ready(function(){

	$('.datepicker').datetimepicker({
		widgetPositioning: {
			horizontal: 'right'
		},
		format:'YYYY-MM-DD',
		debug: false
	});

	$('#from-cnt').datetimepicker({
		widgetPositioning: {
			horizontal: 'right'
		},
		format:'YYYY-MM-DD',
		debug: false
	});
	$('#till-cnt').datetimepicker({
		widgetPositioning: {
			horizontal: 'right'
		},
		format:'YYYY-MM-DD',
		debug: false, 
		useCurrent: false
	});

	$("#from-cnt").on("dp.change", function (e) {
        $('#till-cnt').data("DateTimePicker").minDate(e.date);
    });
    $("#till-cnt").on("dp.change", function (e) {
        $('#from-cnt').data("DateTimePicker").maxDate(e.date);
    });
   
})

/* ==========================================================================
	Datepicker
	========================================================================== */
var isDate = function(date) {
    return (new Date(date) !== "Invalid Date" && !isNaN(new Date(date)) ) ? true : false;

}
