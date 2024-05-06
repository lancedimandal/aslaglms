
  <div class="modal fade" id="addNewClassModal" tabindex="-1" role="dialog" aria-labelledby="addNewClassModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
         <!-- <h5 class="modal-title" id="addNewClassModalLabel">Add New Class</h5> -->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="" enctype="multipart/form-data" class="form" id = "add-class">
            <div class="mb-3">
              <label for="class-name" class="form-label">Class Name (ex. BSIT-4A)</label>
              <input type="text" class="form-control" id="class-name" name="class_name" required>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">Subject:</label>
              <input type="text" class="form-control" id="subject" name="subject" required>
            </div>
            <div class="mb-3">
              <label for="schoolyear" class="form-label">School Year:</label>
              <input type="text" class="form-control" id="schoolyear" name="school_year" required>
            </div>
            <div class="mb-3">
              <label for="class-code" class="form-label">Class Code:</label>
              <input type="text" class="form-control" id="class_code" name="class_code" readonly>
            </div>
            <div class="mb-3">
              <label for="class-image" class="form-label">Class Image:</label>
              <input type="file" class="form-control" id="class-image" name="class_image" accept="image/*" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="add-class-button" name="add_class">Add Class</button>
            <div id="addClassCodeBtn" onclick="generateClassCode(); return false;" class="btn btn-success">Class Code</div>
          </div>
        </form>
      </div>
    </div>
  </div>


<script src = "./admin/bootstrap/js/generate-code.js"></script>
                      <script src = "./admin/bootstrap/js/add_class.js"></script>
              <div class = "title">
                <h2>My Class</h2>
              <!--  <button id="open-modal-btn" class="btn btn-primary class-button" data-toggle="modal" data-target="#addNewClassModal"> 
                  <i class="fa fa-plus" style="margin-right: 5px;"></i>Add New Class -->
                </div>
                <div class="class-list" id="class-list-container">
                    <?php include 'my-class-list.php';?>

                    </div> 
                    
                  
                    

     <!-- Ajax & Jquery for Delete Class -->
<script src="./admin/bootstrap/js/delete_class.js"></script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const openModalBtn = document.getElementById("open-modal-btn");
    const closeModalBtn = document.getElementsByClassName("close-modal-btn")[0];
    const modal = document.getElementById("addNewClassModal"); 
    const modalOverlay = document.getElementsByClassName("modal-backdrop")[0]; 
    const addClassForm = document.getElementById("add-class");

    // Function to open the modal
    function openModal() {
      modal.style.display = "block";
      modalOverlay.style.display = "block";
      document.body.style.overflow = "hidden"; // Prevent scrolling when the modal is open
    }

    // Function to close the modal
    function closeModal() {
      modal.style.display = "none";
      modalOverlay.style.display = "none";
      document.body.style.overflow = "auto"; // Enable scrolling when the modal is closed
      addClassForm.reset(); // Reset the form fields when the modal is closed
    }

    // Event listeners for opening and closing the modal
    openModalBtn.addEventListener("click", openModal);
    closeModalBtn.addEventListener("click", closeModal);
    modalOverlay.addEventListener("click", closeModal);

    // Prevent clicks within the modal content from closing the modal
    modal.addEventListener("click", function (event) {
      event.stopPropagation();
    });

    // Function to handle form submission
    function handleSubmit(event) {
      // Prevent the form from submitting
      event.preventDefault();

      // Add your code to handle the form submission here
      // For example, you can retrieve form data and perform an AJAX request

      // Close the modal after form submission
      closeModal();
    }

    // Attach event listener to the form submit button
    addClassForm.addEventListener("submit", handleSubmit);
  });
</script>

