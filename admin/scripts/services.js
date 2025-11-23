let add_service_form = document.getElementById('add_service_form');

add_service_form.addEventListener('submit', function(e){
  e.preventDefault();
  add_service();
});

function add_service()
{
  let data = new FormData();
  data.append('add_service','');
  data.append('name',add_service_form.elements['name'].value);
  data.append('price',add_service_form.elements['price'].value);
  data.append('desc',add_service_form.elements['desc'].value);
  data.append('image',add_service_form.elements['image'].files[0]);

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/services_crud.php",true);

  xhr.onload = function(){
    var myModal = document.getElementById('add-service-modal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
      alert('success','Dịch vụ mới đã được thêm!');
      add_service_form.reset();
      get_services();
    }
    else{
      alert('error','Thao tác thất bại!');
    }
  }
  xhr.send(data);
}

function get_services()
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/services_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    document.getElementById('services-data').innerHTML = this.responseText;
  }

  xhr.send('get_services');
}

function toggle_status(id,val)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/services_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    if(this.responseText==1){
      alert('success','Trạng thái đã được cập nhật!');
      get_services();
    }
    else{
      alert('error','Thao tác thất bại!');
    }
  }

  xhr.send('toggle_status='+id+'&value='+val);
}


let edit_service_form = document.getElementById('edit_service_form');

function get_service(id)
{
  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/services_crud.php",true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function(){
    let data = JSON.parse(this.responseText);
    let servicedata = data.servicedata;
    
    edit_service_form.elements['name'].value = servicedata.name;
    edit_service_form.elements['price'].value = servicedata.price;
    edit_service_form.elements['desc'].value = servicedata.description;
    edit_service_form.elements['service_id'].value = servicedata.id;
  }

  xhr.send('get_service='+id);
}

edit_service_form.addEventListener('submit', function(e){
  e.preventDefault();
  submit_edit_service();
});

function submit_edit_service()
{
  let data = new FormData();
  data.append('edit_service','');
  data.append('service_id',edit_service_form.elements['service_id'].value);
  data.append('name',edit_service_form.elements['name'].value);
  data.append('price',edit_service_form.elements['price'].value);
  data.append('desc',edit_service_form.elements['desc'].value);
  
  if(edit_service_form.elements['image'].files.length > 0) {
    data.append('image',edit_service_form.elements['image'].files[0]);
  }

  let xhr = new XMLHttpRequest();
  xhr.open("POST","ajax/services_crud.php",true);

  xhr.onload = function(){
    var myModal = document.getElementById('edit-service-modal');
    var modal = bootstrap.Modal.getInstance(myModal);
    modal.hide();

    if(this.responseText == 1){
      alert('success','Dịch vụ đã được cập nhật!');
      edit_service_form.reset();
      get_services();
    }
    else{
      alert('error','Thao tác thất bại!');
    }
  }
  xhr.send(data);
}

function remove_service(id)
{
  if(confirm("Bạn có chắc chắn muốn xóa dịch vụ này?")){
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/services_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
      if(this.responseText==1){
        alert('success','Dịch vụ đã được xóa!');
        get_services();
      }
      else{
        alert('error','Thao tác thất bại!');
      }
    }
    xhr.send('remove_service='+id);
  }
}

window.onload = function(){
  get_services();
} 