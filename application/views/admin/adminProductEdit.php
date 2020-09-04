<?php $product = $vars['product']; ?>


<h4>Edit Product #<?= $product->getProductId() ?></h4>
<div class="row">
    <div class="col-lg-4">
        <div class="login-form">
            <form action="#" method="post" enctype="multipart/form-data">

                <p>Product Name</p>
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="" value="<?= $product->getProductName() ?>">
                </div>
                <p>Product Id</p>
                <div class="form-group">
                    <input class="form-control" type="text" name="code" placeholder="" value="<?= $product->getProductId() ?>">
                </div>
                <p>Price, $</p>
                <div class="form-group">
                    <input class="form-control" type="text" name="price" placeholder="" value="<?= $product->getPrice() ?>">
                </div>
                <p>Category</p>
                <div class="form-group">
                    <select name="category_id">
                        <option value="helmet">helmet</option>
                        <option value="jacket">jacket</option>
                        <option value="pants">pants</option>
                        <option value="boots">boots</option>
                        <option value="gloves">gloves</option>
                    </select>
                </div>

                <p>Brand</p>
                <div class="form-group">
                    <input class="form-control" type="text" name="brand" placeholder="" value="<?= $product->getBrand() ?>">
                </div>
                <p>Product Image</p>
                <img src="<?= $product->getImgPath() ?>" width="200" alt="" />
                <input class="m-2" type="file" name="image" placeholder="" value="<?= $product->getImgPath() ?>">

                <p>Product Description</p>
                <textarea class="form-control" name="description">sdvsdvsdvsdvsdvdsvs</textarea>


                <button type="submit" name="submit" class="btn btn-primary my-4">Submit</button>
            </form>
        </div>
    </div>

</div>
</section>