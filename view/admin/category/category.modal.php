<!-- Add Category Modal -->
<div class="modal fade" id="categoryAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="saveCategory">
                <div class="modal-body">

                    <div id="errorMessage" class="alert alert-danger d-none"></div>

                    <div class="mb-3">
                        <label for="">Name</label>
                        <div>
                            <input type="text" name="name" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand">Brand</label>
                        <div>
                            <select name="brand_id" class="form-select">
                                <option value="default">-----select a brand----</option>
                                <?php

                                include_once('../../../modal/admin/brand/brand.php');
                                $obj = new Brand();
                                $query = $obj->getBrandData();

                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='$row[id]'>$row[name]</option>";
                                }
                                ?>
                            </select>
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

<!-- View Category Modal -->
<div class="modal fade" id="categoryViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Category Name</label>
                    <p id="view_category_name" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Brand Name</label>
                    <p id="view_brand_name" class="form-control"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="categoryEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateCategory">
                <div class="modal-body">

                    <div id="errorMessageUpdate" class="alert alert-danger d-none"></div>
                    <input type="hidden" name="edit_category_id" id="edit_category_id">
                    <div class="mb-3">
                        <label for="">Name</label>
                        <div>
                            <input type="text" name="name" id="edit_category_name" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="brand">Brand</label>
                        <div>
                            <select name="brand_id" class="form-select editSelectedOption" id="">
                                <option value="default">-----select a brand----</option>
                                <?php

                                include_once('../../../modal/admin/brand/brand.php');
                                $obj = new Brand();
                                $query = $obj->getBrandData();

                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<option value='$row[id]'>$row[name]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>