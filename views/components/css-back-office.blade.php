<style type="text/css">
button.details-data {
    background: url('{{asset("assets/general/datatables/images/vv.png")}}') no-repeat center center;
    padding: 10px;
    border: none;
    cursor: pointer;
}

button.details-data:focus {
    outline:none !important;
    cursor: pointer;
}

tr.shown button.details-data {
    background: url('{{asset("assets/general/datatables/images/xx.png")}}') no-repeat center center;
}

tr.shown button.details-data:focus {
    outline:none !important;
}

input[type="checkbox"][readonly] {
  pointer-events: none;
}

.status-menunggu-approval {
	background-color: #c9c9b8;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-menunggu-approval:hover {
	background-color: #8c8c66;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
	border: none;
}

 button.status-menunggu-approval:focus{
 	outline:none !important;
 }

.status-diterima {
	background-color: #ffdb00;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-diterima:hover {
	background-color: #ffcf00;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
	border: none;
}

 button.status-diterima:focus{
 	outline:none !important;
 }

.status-diteruskan {
	background-color: #85c2ff;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-diteruskan:hover {
	background-color: #47a3ff;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

 button.status-diteruskan:focus{
 outline:none !important;
 }

.status-diproses {
	background-color: #4d94ff;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-diproses:hover {
	background-color: #267dff;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

 button.status-diproses:focus{
 outline:none !important;
 }

.status-ditanggapi {
	background-color: #6685e0;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-ditanggapi:hover {
	background-color: #335cd6;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

 button.status-ditanggapi:focus{
 outline:none !important;
 }

.status-ditolak-ppid {
	background-color: #ff5959;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-ditolak-ppid:hover {
	background-color: #ff2626;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

 button.status-ditolak-ppid:focus{
 outline:none !important;
 }

.status-ditolak-uk {
	background-color: #e06666;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-ditolak-uk:hover {
	background-color: #d63333;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

 button.status-ditolak-uk:focus{
 outline:none !important;
 }

.status-selesai {
	background-color: #bdff7a;
	font-weight:bold;
	color:#333333;
	border: none;
}

.status-selesai:hover {
	background-color: #99ff33;
	border-radius: 10px;
	font-weight:bold;
	color:#333333;
}

button.status-selesai:focus{
 outline:none !important;
}

 .no-pendaftaran:hover{
 	cursor: pointer;
 	color: #a68547;
}

.text-modify-1{
 	color: #806666;
}

.btn-custom-1, .btn-custom-1.disabled {
  box-shadow: 0 2px 6px #a6dbed; 
  background-color: #59bdde;
  border-color: #59bdde; 
  color: #fff; 
}
 .btn-custom-1:hover, .btn-custom-1:focus, .btn-custom-1:active, .btn-custom-1.disabled:hover, .btn-custom-1.disabled:focus, .btn-custom-1.disabled:active {
    background-color: #19a3d1 !important;
	color: #fff; 
} 

.btn-custom-2, .btn-custom-2.disabled {
  box-shadow: 0 2px 6px #e38f73; 
  background-color: #db704d;
  border-color: #db704d; 
  color: #fff; 
}
 .btn-custom-2:hover, .btn-custom-2:focus, .btn-custom-2:active, .btn-custom-2.disabled:hover, .btn-custom-2.disabled:focus, .btn-custom-2.disabled:active {
    background-color: #d14719 !important;
	color: #fff; 
}  

.btn-custom-3, .btn-custom-3.disabled {
  box-shadow: 0 2px 6px #99b2ff;
  background-color: #668cff;
  border-color: #668cff;
  color: #fff; 
}
.btn-custom-3:hover, .btn-custom-3:focus, .btn-custom-3:active, .btn-custom-3.disabled:hover, .btn-custom-3.disabled:focus, .btn-custom-3.disabled:active {
    background-color: #4775ff !important; 
	color: #fff; 
}  

</style>