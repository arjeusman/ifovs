<!-- Add Modal -->
<div class="modal fade" id="edit" tabindex="-1" data-bs-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width: 600px">
    <form onsubmit="Submit(this)" method="post" class="modal-content needs-validation" novalidate>
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-pencil"></i> Edit Employee</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input id="id" type="hidden" name="id"/>
        <div class="row">
          <div class="col">
            <label class="form-label" for="first_name">First Name</label>
            <input id="first_name" type="text" name="first_name" class="form-control mb-2" autocomplete="off" required>
          </div>
          <div class="col">
            <label class="form-label" for="middle_name">Middle Name</label>
            <input id="middle_name" type="text" name="middle_name" class="form-control mb-2" autocomplete="off" required>
          </div>
          <div class="col">
            <label class="form-label" for="last_name">Last Name</label>
            <input id="last_name" type="text" name="last_name" class="form-control mb-2" autocomplete="off" required>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="gender" class="form-control" required>
              <option value="">Select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
          <div class="col">
            <label for="age" class="form-label">Age</label>
            <input type="number" id="age" name="age" class="form-control" autocomplete="off" required>
          </div>
          <div class="col">
            <label for="civil_status" class="form-label">Civil Status</label>
            <select id="civil_status" name="civil_status" class="form-control" required>
              <option value="">Select</option>
              <option value="single">Single</option>
              <option value="married">Married</option>
              <option value="divorced">Divorced</option>
              <option value="widowed">Widowed</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="form-label" for="email_address">Email Address</label>
            <input id="email_address" type="email" name="email_address" class="form-control mb-2" autocomplete="off" required>
          </div>
          <div class="col-4">
            <label class="form-label" for="phone_number">Phone Number</label>
            <input id="phone_number" type="number" name="phone_number" class="form-control mb-2" autocomplete="off" required>
          </div>
        </div>
        <h1 class="fs-4 mb-2">Address</h1>
        <div class="row mb-2">
          <div class="col">
            <label for="address_purok" class="form-label">Purok or Street</label>
            <input type="text" id="address_purok" name="address_purok" class="form-control" autocomplete="off" required>
          </div>
          <div class="col">
            <label for="address_barangay" class="form-label">Barangay</label>
            <input type="text" id="address_barangay" name="address_barangay" class="form-control" autocomplete="off" required>
          </div>
          <div class="col">
            <label for="address_municipality" class="form-label">Municipality</label>
            <input type="text" id="address_municipality" name="address_municipality" class="form-control" autocomplete="off" required>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label for="address_province" class="form-label">Province</label>
            <input type="text" id="address_province" name="address_province" class="form-control" autocomplete="off" required>
          </div>
          <div class="col-4">
            <label for="address_zip" class="form-label">ZIP Code</label>
            <input type="number" id="address_zip" name="address_zip" class="form-control" autocomplete="off" required>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="edit" class="btn btn-success bg-gradient"><i class="bi bi-floppy"></i> Save Changes</button>
      </div>
    </form>
  </div>
</div>
<!-- Add Modal -->