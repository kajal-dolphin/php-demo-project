 <!-- Add Product Modal -->
 <div class="modal fade" id="productAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="saveProduct" enctype="multipart/form-data">
                 <div class="modal-body">
                     <div id="errorMessage" class="alert alert-danger d-none"></div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for="">Name</label>
                             <div>
                                 <input type="text" name="name" class="form-control" />
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col mb-3">
                             <label><strong>Description :</strong></label>
                             <textarea class="ckeditor form-control" name="description" height="30" width="30"></textarea>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for="brand">Brand</label>
                             <div>
                                 <select name="brand_id" class="form-select">
                                     <option value="default">-----select a brand----</option>
                                     <?php
                                        include('../../../config/db.php');
                                        $sql = "SELECT * FROM brands";
                                        $query = mysqli_query($connection, $sql);

                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "<option value='$row[id]'>$row[name]</option>";
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Category</label>
                             <div>
                                 <select name="category_id" class="form-select">

                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for="">Price</label>
                             <div>
                                 <input type="number" class="form-control" name="price" min="0" />
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Model Year</label>
                             <div>
                                 <input type="text" class="form-control yearpicker" id="model_year" name="model_year">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for=""> Feature </label>
                             <div>
                                 <select name="feature" id="" class="form-select">
                                     <option value="default">-----select a feature----</option>
                                     <option value="automatic"> Automatic </option>
                                     <option value="electrical"> Electrical</option>
                                     <option value="petrol"> Petrol</option>
                                     <option value="diesel"> Diesel</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Image</label>
                             <div>
                                 <input type="file" name="images[]" class="form-control" multiple>
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

 <!-- View Product Modal -->
 <div class="modal fade" id="productViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">View Product</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">
                 <div class="mb-3">
                     <label for="">Name</label>
                     <p id="view_name" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Description</label>
                     <p id="view_description" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Brand Name</label>
                     <p id="view_brand_name" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Category Name</label>
                     <p id="view_category_name" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Price</label>
                     <p id="view_price" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Model Year</label>
                     <p id="view_model_year" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Feature</label>
                     <p id="view_feature" class="form-control"></p>
                 </div>
                 <div class="mb-3">
                     <label for="">Image</label>
                     <div class="imageContainer">

                     </div>
                 </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>

 <!-- Edit Product Modal -->
 <div class="modal fade" id="productEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form id="updateProduct">
                 <div class="modal-body">
                     <div id="errorMessageUpdate" class="alert alert-success d-none"></div>
                     <input type="hidden" name="edit_product_id" id="edit_product_id">
                     <div class="row">
                         <div class="col mb-3">
                             <label for="">Name</label>
                             <div>
                                 <input type="text" name="name" class="form-control" id="edit_name" />
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col mb-3">
                             <label><strong>Description :</strong></label>
                             <textarea class="ckeditor form-control" name="description" height="30" width="30" id="edit_description"></textarea>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for="brand">Brand</label>
                             <div>
                                 <select name="brand_id" class="form-select selectedBrandOption selectedBrandId" id="selectedBrandId">
                                     <option value="default">-----select a brand----</option>
                                     <?php
                                        include('../../../config/db.php');
                                        $sql = "SELECT * FROM brands";
                                        $query = mysqli_query($connection, $sql);

                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "<option value='$row[id]'>$row[name]</option>";
                                        }
                                        ?>
                                 </select>
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Category</label>
                             <div>
                                 <select name="category_id" class="form-select editSelectedCategory">

                                 </select>
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for="">Price</label>
                             <div>
                                 <input type="number" class="form-control" name="price" min="0" id="edit_price" />
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Model Year</label>
                             <div>
                                 <input type="text" class="form-control yearpicker" name="model_year" id="edit_model_year">
                             </div>
                         </div>
                     </div>
                     <div class="row">
                         <div class="col mb-3">
                             <label for=""> Feature </label>
                             <div>
                                 <select name="feature" id="" class="form-select editSelectedFeature">
                                     <option value="default">-----select a feature----</option>
                                     <option value="automatic"> Automatic </option>
                                     <option value="electrical"> Electrical</option>
                                     <option value="petrol"> Petrol</option>
                                     <option value="diesel"> Diesel</option>
                                 </select>
                             </div>
                         </div>
                         <div class="col mb-3">
                             <label for="">Image</label>
                             <div>
                                 <input type="file" name="images[]" class="form-control" multiple>
                             </div>
                             <div class="editImageContainer" style="display: flex;">

                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                     <button type="submit" class="btn btn-primary">Update Product</button>
                 </div>
             </form>
         </div>
     </div>
 </div>