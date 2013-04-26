$(document).ready(function() {

//get the current number of elements
var i = $(".HistoryGroup").size();

//register event handler
$(".remove").click(function() {
  //get the parent 
  //removes parent div and contents
  $(this).parent().remove();
});


//Adds more entries for work history 
$('#add').click(function() {
   var history = '\<div class="HistoryGroup" id="' + i + '"><label class="control-label" for="description">Dates Employed</label>\
  <a class="btn btn-danger pull-right remove" id="' + i + '">remove</a>\
          <div class="control-group">\
           <div class="controls">\
            <input type="text" class="input-small" placeholder="Start Date" name="beg[]">\
            <input type="text" class="input-small" placeholder="End Date" name="end[]">\
            </div>\
        </div>\
      <label class="control-label" for="description">Description</label>\
      <div class="control-group">\
         <div class="controls">\
            <textarea placeholder="Job Description" rows="2" name="job[]"></textarea>\
          </div>\
      </div>\
      </div>';
    // Now we can use this to add the new element
    $('.eHistory').append(history);
  //registers event handler
  $('#'+i+' a').click(function() {
  
  $(this).parent().remove();
   i--;
  });
     i++;


  });
});