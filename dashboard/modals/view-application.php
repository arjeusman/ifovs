<!-- Edit Modal -->
<div class="modal fade" id="read" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 350px">
    <form method="post" class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5"><i class="bi bi-journal-text"></i> Application</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <table class="table m-0">
        	<tbody>
        		<tr>
        			<td>App. ID</td>
        			<td id="id"></td>
        		</tr>
        		<tr>
        			<td>Full Name</td>
        			<td id="fullname"></td>
        		</tr>
        		<tr>
        			<td>Gender</td>
        			<td id="gender" class="text-capitalize"></td>
        		</tr>
        		<tr>
        			<td>Age & Status</td>
        			<td id="age_status" class="text-capitalize"></td>
        		</tr>
        		<tr>
        			<td>Email</td>
        			<td id="email"></td>
        		</tr>
        		<tr>
        			<td>Number</td>
        			<td id="phone"></td>
        		</tr>
        		<tr>
        			<td>Address</td>
        			<td id="address"></td>
        		</tr>
        		<tr>
        			<td colspan="100%">
        				<center>
                  <a id="resume" href="#" target="_blank" class="btn btn-lg px-4 py-2 btn-success bg-gradient"><i class="bi bi-folder-fill"></i> View resume</a>    
                </center>
        			</td>
        		</tr>
        	</tbody>
        </table>
      </div>
    </form>
  </div>
</div>
<!-- Add Modal -->