<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Shipping Policy</h1>

    <div class="prose prose-lg max-w-none text-gray-600">
        <p>At <span class="font-bold">{{ config('app.name', 'Laravel') }}</span>, we are committed to delivering your orders as quickly and efficiently as possible. Our Shipping Policy outlines the details of our shipping process, including methods, costs, and delivery timelines, to ensure a smooth shopping experience.</p>

        <p>This policy applies to all orders placed through <span class="font-bold">{{ config('app.name', 'Laravel') }}</span>. Please review the information below to understand how we handle shipping.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">1. Shipping Methods</h2>

        <p>We offer a variety of shipping methods to meet your needs. The available options will be displayed during checkout, depending on your location and order details:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Standard Shipping</span>: Estimated delivery within <span class="underline">5-7 business days</span>.</li>
            <li><span class="font-bold">Expedited Shipping</span>: Estimated delivery within <span class="underline">2-3 business days</span>.</li>
            <li><span class="font-bold">Overnight Shipping</span>: Estimated delivery within <span class="underline">1 business day</span> (available for select locations).</li>
        </ul>

        <p><span class="italic">Note</span>: Shipping methods and availability may vary based on your location and the items in your order.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">2. Shipping Costs</h2>

        <p>Shipping costs are calculated based on the <span class="font-bold">weight</span>, <span class="font-bold">dimensions</span>, and <span class="font-bold">destination</span> of your order, as well as the selected shipping method. You will see the exact shipping cost during checkout before completing your purchase.</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Free Shipping</span>: Available on orders over <span class="underline">$50</span> for standard shipping to select regions (check eligibility at checkout).</li>
            <li><span class="font-bold">Additional Fees</span>: International orders may incur customs duties, taxes, or import fees, which are the responsibility of the customer.</li>
        </ul>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">3. Order Processing</h2>

        <p>Orders are typically processed within <span class="font-bold">1-2 business days</span> after payment confirmation. During peak seasons or promotions, processing may take up to <span class="underline">3 business days</span>.</p>

        <p>Once your order is processed, you will receive a confirmation email with shipping details. Orders placed after <span class="italic">2:00 PM PKT</span> may be processed the next business day.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">4. Delivery Times</h2>

        <p>Delivery times depend on your selected shipping method and destination:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Domestic Shipping</span>: <span class="underline">3-7 business days</span> for standard shipping, depending on your location.</li>
            <li><span class="font-bold">International Shipping</span>: <span class="underline">7-14 business days</span>, depending on the destination and customs processing.</li>
        </ul>

        <p><span class="italic">Please note</span>: Delivery times are estimates and not guaranteed. Delays may occur due to weather, holidays, or carrier issues.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">5. International Shipping</h2>

        <p>We ship to <span class="underline">select international destinations</span>, including <span class="italic">Pakistan, United States, Canada, United Kingdom, and Australia</span>. International customers are responsible for:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Customs Duties and Taxes</span>: Any applicable fees imposed by your country’s customs service.</li>
            <li><span class="font-bold">Compliance</span>: Ensuring your order complies with local import regulations.</li>
        </ul>

        <p>Please check with your local customs office for details before placing an order.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">6. Tracking Your Order</h2>

        <p>Once your order ships, you will receive an email with a <span class="font-bold">tracking number</span> and a link to track your package on the carrier’s website. If you don’t receive tracking information within <span class="underline">3 business days</span> of your order confirmation, please contact us.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">7. Lost or Damaged Shipments</h2>

        <p>If your order is lost or arrives damaged:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Lost Shipments</span>: Contact us within <span class="underline">30 days</span> of your order date, and we will work with the carrier to locate your package or provide a refund/replacement.</li>
            <li><span class="font-bold">Damaged Shipments</span>: Report damage within <span class="underline">7 days</span> of delivery, and we will provide a prepaid return label and a refund or replacement.</li>
        </ul>

        <p>Please refer to our <a href="/return-policy" class="text-purple-600 hover:underline">Return Policy</a> for additional details.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">8. Contact Information</h2>

        <p>If you have questions about our Shipping Policy or need assistance with your order, please reach out to us at:</p>

        <p><span class="font-bold">Email</span>: <a wire:prevent class="text-purple-600 hover:underline">support@example.com</a></p>
        <p><span class="font-bold">Mailing Address</span>: {{ config('app.name', 'Laravel') }} Support Team, 1234 Commerce Lane, Suite 500, Business City, BC 56789</p>

        <p>We aim to respond to all inquiries within <span class="underline">30 days</span>.</p>

        <div class="alert bg-softPurple border-0 text-gray-500 mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="stroke-current shrink-0 w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>This Shipping Policy was last updated on {{ date('F j, Y') }}.</span>
        </div>
    </div>
</div>
