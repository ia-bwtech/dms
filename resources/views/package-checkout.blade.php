{{-- @dd($data->user->stripe_connected) --}}
<!DOCTYPE html>
<html lang="en" >
<head>
	<script src="https://js.stripe.com/v3/"></script>
	<meta charset="UTF-8">
  <title>Buy Package - Blind Side Bets</title>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">

</head>
<body>

<div id="wrapper">
	<div id="container">
		<div id="left-col">
			<div id="left-col-cont">
				<a href="/"><img src="{{ asset('assets/images/header-logo2.png') }}" width="75%;" align="Logo" class="img-fluid"></a>
				<h2>Summary</h2>
				<div class="item">
				</div>
				<h4 id="total-price">{{ $data->name }}</h4>
				<p id="total">Total</p>
				<h4 id="total-price">${{ $data->price }}</h4>
			</div>
		</div>
		<div id="right-col">
			<h2>Payment</h2>

			<form action="">
				<div class="form-group">
					<label for="">Name</label>
					<input class="form-control" type="text" disabled value="{{ auth()->user()->name }}">
				</div>
				<div class="form-group">
					<label for="">Email</label>
					<input class="form-control" type="text" disabled value="{{ auth()->user()->email }}">
				</div>
			</form>

			@if($data->user->stripe_connected == 1)
			<form id="payment-form" data-secret="{{ $intent->client_secret }}">
				<div id="payment-element">
					<!-- Elements will create form elements here -->
				</div>
				<button class="btn btn-danger stripeBtn" id="submit">Submit</button>
				<div id="error-message">
					<!-- Display error message to your customers here -->
				</div>
				<br>
			</form>
			@endif

			@if(in_array($data->user_id, [2, 10, 16]))					{{-- Enabling only selected Paypal accounts for payment --}}
				<div id="paypal-button-container"></div>
				<!-- Sample PayPal credentials (client-id) are included -->
				<script src="https://www.paypal.com/sdk/js?client-id=AVPi1uPgYyD94us_3QG8BoolNPSc_ktpr7TrEZFaOpRSh-kNni_m-eqTLVuhtbLSl6vsxBp-jE2RiZPN&currency=USD&intent=capture" data-sdk-integration-source="integrationbuilder"></script>

				<script>
					const fundingSources = [
						paypal.FUNDING.PAYPAL
						]

					for (const fundingSource of fundingSources) {
						const paypalButtonsComponent = paypal.Buttons({
						fundingSource: fundingSource,

						// optional styling for buttons
						// https://developer.paypal.com/docs/checkout/standard/customize/buttons-style-guide/
						style: {
							shape: 'pill',
							height: 40,
						},

						// set up the transaction
						createOrder: (data, actions) => {
							// pass in any options from the v2 orders create call:
							// https://developer.paypal.com/api/orders/v2/#orders-create-request-body
							const createOrderPayload = {
							purchase_units: [
								{
								amount: {
									value: "{{ $data->price }}",
								},
								description: "{{ $data->id }}",
								},
							],
							}

							return actions.order.create(createOrderPayload)
						},

						// finalize the transaction
						onApprove: (data, actions) => {
							const captureOrderHandler = (details) => {
							const payerName = details.payer.name.given_name
							console.log('Transaction completed!');
							console.log(details);
							window.location.href = "/paypal/payment/success?data=" + JSON.stringify(details);
							}

							return actions.order.capture().then(captureOrderHandler)
						},

						// handle unrecoverable errors
						onError: (err) => {
							console.error(
							'An error prevented the buyer from checking out with PayPal',
							);
							console.log(err);
						},
						})

						if (paypalButtonsComponent.isEligible()) {
						paypalButtonsComponent
							.render('#paypal-button-container')
							.catch((err) => {
							console.error('PayPal Buttons failed to render')
							})
						} else {
						console.log('The funding source is ineligible')
						}
					}
					</script>
					@endif
		</div>
	</div>
</div>
<!-- partial -->


@if($data->user->stripe_connected == 1)
<script>
	const stripe = Stripe('{{ $stripePublishableKey }}');

	const options = {
		clientSecret: "{{ $intent->client_secret }}",
		// Fully customizable with appearance API.
		appearance: {
			theme: 'stripe',
		},
	};

	// Set up Stripe.js and Elements to use in checkout form, passing the client secret obtained in step 2
	const elements = stripe.elements(options);

	// Create and mount the Payment Element
	const paymentElement = elements.create('payment');
	paymentElement.mount('#payment-element');

	const form = document.getElementById('payment-form');

	form.addEventListener('submit', async (event) => {
	document.getElementsByClassName("stripeBtn")[0].style.backgroundColor = "gray";
	event.preventDefault();

	const {error} = await stripe.confirmPayment({
		//`Elements` instance that was used to create the Payment Element
		elements,
		confirmParams: {
		// return_url: 'http://hunch-atl.test/payment-success',
		return_url: "{{ url('/') }}/payment-success",
		},
	});

	if (error) {
		// This point will only be reached if there is an immediate error when
		// confirming the payment. Show error to your customer (for example, payment
		// details incomplete)
		const messageContainer = document.querySelector('#error-message');
		messageContainer.textContent = error.message;
	} else {
		// Your customer will be redirected to your `return_url`. For some payment
		// methods like iDEAL, your customer will be redirected to an intermediate
		// site first to authorize the payment, then redirected to the `return_url`.
	}
	});
</script>
@endif

</body>
</html>
