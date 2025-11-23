function get_bookings(search='')
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/new_bookings.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('table-data').innerHTML = this.responseText;
  }
  xhr.send('get_bookings&search='+search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(id){
  assign_room_form.elements['booking_id'].value=id;
}

assign_room_form.addEventListener('submit',function(e){
  e.preventDefault();
  
  let data = new FormData();
  data.append('room_no',assign_room_form.elements['room_no'].value);
  data.append('booking_id',assign_room_form.elements['booking_id'].value);
  data.append('assign_room','');

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/new_bookings.php",true);

  xhr.onload = function(){
    var myModal = document.getElementById('assign-room');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText==1){
      alert('success','Room Number Alloted! Booking Finalized!');
      assign_room_form.reset();
      get_bookings();
    }
    else{
      alert('error','Server Down!');
    }
  }

  xhr.send(data);
});

function add_service_to_booking(booking_id) {
  let add_service_modal = document.getElementById('add-service-booking-modal');
  let add_service_form = document.getElementById('add_service_booking_form');
  
  add_service_form.elements['booking_id'].value = booking_id;
  
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/new_bookings.php", true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  xhr.onload = function() {
    document.getElementById('services-list').innerHTML = this.responseText;
  }
  
  xhr.send('get_all_services=1');
}

let add_service_booking_form = document.getElementById('add_service_booking_form');
add_service_booking_form.addEventListener('submit', function(e) {
  e.preventDefault();

  let selected_services = [];
  let service_checkboxes = add_service_booking_form.querySelectorAll("input[name='services']:checked");
  
  service_checkboxes.forEach(function(checkbox) {
    let service_id = checkbox.value;
    let quantity = add_service_booking_form.querySelector("input[name='quantity_" + service_id + "']").value;
    selected_services.push({ id: service_id, quantity: quantity });
  });

  if (selected_services.length === 0) {
    alert('error', 'Vui lòng chọn ít nhất một dịch vụ!');
    return;
  }

  let data = new FormData();
  data.append('booking_id', add_service_booking_form.elements['booking_id'].value);
  data.append('services', JSON.stringify(selected_services));
  data.append('add_service_to_booking_form', '');

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "ajax/new_bookings.php", true);

  xhr.onload = function() {
    var myModal = document.getElementById('add-service-booking-modal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if (this.responseText == 1) {
      alert('success', 'Dịch vụ đã được thêm thành công!');
      get_bookings();
    } else {
      alert('error', 'Có lỗi xảy ra, không thể thêm dịch vụ!');
    }
  }

  xhr.send(data);
});

function cancel_booking(id) 
{
  if(confirm("Are you sure, you want to cancel this booking?"))
  {
    let data = new FormData();
    data.append('booking_id',id);
    data.append('cancel_booking','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/new_bookings.php",true);

    xhr.onload = function()
    {
      if(this.responseText == 1){
        alert('success','Booking Cancelled!');
        get_bookings();
      }
      else{
        alert('error','Server Down!');
      }
    }

    xhr.send(data);
  }
}

window.onload = function(){
  get_bookings();
}