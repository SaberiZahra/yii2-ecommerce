<?php
/** @var \common\models\Order $order */

$orderAddress = $order->orderAddress
?>
<!--<script src="https://www.paypal.com/sdk/js?client-id=--><?php //echo param('paypalClientId') ?><!--"></script>-->

<h3>Order #<?php echo $order->id ?> summary: </h3>
<hr>
<div class="row">
    <div class="col">
        <h5>Account information</h5>
        <table class="table">
            <tr>
                <th>Firstname</th>
                <td><?php echo $order->firstname ?></td>
            </tr>
            <tr>
                <th>Lastname</th>
                <td><?php echo $order->lastname ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $order->email ?></td>
            </tr>
        </table>
        <h5>Address information</h5>
        <table class="table">
            <tr>
                <th>Address</th>
                <td><?php echo $orderAddress->address ?></td>
            </tr>
            <tr>
                <th>City</th>
                <td><?php echo $orderAddress->city ?></td>
            </tr>
            <tr>
                <th>State</th>
                <td><?php echo $orderAddress->state ?></td>
            </tr>
            <tr>
                <th>Country</th>
                <td><?php echo $orderAddress->country ?></td>
            </tr>
            <tr>
                <th>ZipCode</th>
                <td><?php echo $orderAddress->zipcode ?></td>
            </tr>
        </table>
    </div>
    <div class="col">
        <h5>Products</h5>
        <table class="table table-sm">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($order->orderItems as $item): ?>
                <tr>
                    <td>
                        <img src="<?php echo $item->product->getImageUrl() ?>"
                            style="width: 50px;">
                    </td>
                    <td><?php echo $item->product_name ?></td>
                    <td><?php echo $item->quantity ?></td>
                    <td><?php echo Yii::$app->formatter->asCurrency($item->quantity * $item->unit_price) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <hr>
        <table class="table">
            <tr>
                <th>Total Items</th>
                <td><?php echo $order->getItemsQuantity() ?></td>
            </tr>
            <tr>
                <th>Total Price</th>
                <td><?php echo Yii::$app->formatter->asCurrency($order->total_price) ?></td>
            </tr>
        </table>

        <?php
        use yii\helpers\Url;
        ?>

        <div class="text-center mt-4">
            <button id="fake-pay-button" class="btn btn-lg btn-primary">
                Pay Now (Test)
            </button>
        </div>

        <script>
            document.getElementById('fake-pay-button').addEventListener('click', function () {
                if (!confirm('Are you sure you want to submit payment for this order?')) {
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: '<?php echo Url::to(['/cart/fake-pay', 'orderId' => $order->id]) ?>',
                    success: function (res) {
                        alert('Payment completed successfully.');
                        window.location.href = '<?php echo Url::to(['/site/index']) ?>';
                    },
                    error: function () {
                        alert('Payment failed. Please try again.');
                    }
                });
            });
        </script>

        <!--        <div id="paypal-button-container"></div>-->
    </div>
</div>
<script>
  //paypal.Buttons({
  //  createOrder: function (data, actions) {
  //    // This function sets up the details of the transaction, including the amount and line item details.
  //    return actions.order.create({
  //      purchase_units: [{
  //        amount: {
  //          value: <?php //echo $order->total_price ?>
  //        }
  //      }]
  //    });
  //  },
  //  onApprove: function (data, actions) {
  //    console.log(data, actions);
  //    // This function captures the funds from the transaction.
  //    return actions.order.capture().then(function (details) {
  //      console.log(details);
  //      const $form = $('#checkout-form');
  //      const formData = $form.serializeArray();
  //      formData.push({
  //        name: 'transactionId',
  //        value: details.id
  //      });
  //      formData.push({
  //        name: 'orderId',
  //        value: data.orderID
  //      });
  //      formData.push({
  //        name: 'status',
  //        value: details.status
  //      });
  //      $.ajax({
  //        method: 'post',
  //        url: '<?php //echo \yii\helpers\Url::to(['/cart/submit-payment', 'orderId' => $order->id])?>//',
  //        data: formData,
  //        success: function (res) {
  //          // This function shows a transaction success message to your buyer.
  //          alert("Thanks for your business");
  //          window.location.href = '';
  //        }
  //      })
  //    });
  //  }
  //}).render('#paypal-button-container');
   // This function displays Smart Payment Buttons on your web page.
</script>