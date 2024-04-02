 <!-- Add Brand Modal -->
 <div class="modal fade" id="brandAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="saveBrand">
                 <div class="modal-body">

                     <div id="errorMessage" class="alert alert-danger d-none"></div>

                     <div class="mb-3">
                         <label for="">Name</label>
                         <div>
                             <input type="text" name="name" class="form-control" />
                         </div>
                     </div>
                     <div class="mb-3">
                         <label for="">Image</label>
                         <div>
                             <input type="file" name="image" class="form-control" onchange="imagePreview(this);" />
                             <div id="imagePreviewContainer" style="display: none;">
                                 <img id="previewImage" alt="your image" height="100px" width="100px" class="pt-2">
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Save</button>
                 </div>
             </form>
         </div>
     </div>
 </div>

 <!-- View Brand Modal -->
 <div class="modal fade" id="brandViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">View Brand</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="mb-3">
                     <label for="">Name</label>
                     <p id="view_name" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Image</label>
                     <p>
                         <img src="" alt="" id="view_image" height="100px" width="100px">
                     </p>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>


 <!-- Edit Brand Modal -->
 <div class="modal fade" id="brandEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="updateBrand">
                 <div class="modal-body">

                     <div id="errorMessageUpdate" class="alert alert-danger d-none"></div>

                     <input type="hidden" name="edit_brand_id" id="edit_brand_id">
                     <input type="hidden" name="edit_old_image" id="edit_old_image">

                     <div class="mb-3">
                         <label for="">Name</label>
                         <div>
                             <input type="text" name="name" id="edit_name" class="form-control" />
                         </div>
                     </div>
                     <div class="mb-3">
                         <label for="">Image</label>
                         <div>
                             <input type="file" name="image" id="image" class="form-control" />
                         </div>
                         <img src="" alt="" id="edit_image" height="100" width="100" class="pt-2">
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Update Brand</button>
                 </div>
             </form>
         </div>
     </div>
 </div>