<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Return Policy</h1>

    <div class="prose prose-lg text-gray-600 max-w-none">
        <p>At <span class="font-bold">{{ config('app.name', 'Laravel') }}</span>, we want you to be completely satisfied
            with your purchase. Our Return Policy is designed to make returns and refunds as straightforward as
            possible. If you’re not happy with your order, we’re here to help. Please review the details below to
            understand our return process.</p>

        <p>This policy applies to all purchases made through <span
                class="font-bold">{{ config('app.name', 'Laravel') }}</span>, whether online or via other approved
            channels.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">1. Eligibility for Returns</h2>

        <p>You may return most items purchased from <span class="font-bold">{{ config('app.name', 'Laravel') }}</span>
            within <span class="underline">30 calendar days</span> from the date you receive your order. To be eligible
            for a return, your item must meet the following conditions:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Unused Condition</span>: The item must be <span class="italic">unused</span> and
                in the same condition as when you received it.</li>
            <li><span class="font-bold">Original Packaging</span>: The item must be returned in its <span
                    class="italic">original packaging</span>, including all tags, labels, and accessories.</li>
            <li><span class="font-bold">Proof of Purchase</span>: You must provide a receipt or proof of purchase (e.g.,
                order confirmation email or order number).</li>
        </ul>

        <p><span class="font-bold">Non-Returnable Items</span>: Certain items, such as <span class="italic">personalized
                products</span>, <span class="italic">perishable goods</span>, or <span class="italic">digital
                downloads</span>, are not eligible for return unless defective or damaged.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">2. Refund Process</h2>

        <p>Once we receive and inspect your returned item, we will notify you via email about the approval or rejection
            of your refund. If approved:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Refund Issuance</span>: Your refund will be processed to your original payment
                method (e.g., credit card, debit card) within <span class="underline">7-10 business days</span>.</li>
            <li><span class="font-bold">Shipping Costs</span>: Original shipping costs are <span
                    class="italic">non-refundable</span>, and you are responsible for return shipping costs unless the
                item is defective.</li>
            <li><span class="font-bold">Partial Refunds</span>: Items returned in a condition that does not meet our
                policy (e.g., used or damaged) may be eligible for a partial refund at our discretion.</li>
        </ul>

        <p>Please note that refund processing times may vary depending on your payment provider’s policies.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">3. Defective or Damaged Items</h2>

        <p>If you receive a <span class="font-bold">defective</span>, <span class="font-bold">damaged</span>, or <span
                class="font-bold">incorrect item</span>, please contact us immediately. We will provide a prepaid return
            shipping label and offer one of the following options:</p>

        <ul class="list-disc ml-6 space-y-2">
            <li><span class="font-bold">Replacement</span>: A replacement item, if available, at no additional cost.
            </li>
            <li><span class="font-bold">Full Refund</span>: A full refund, including original shipping costs, to your
                payment method.</li>
            <li><span class="font-bold">Store Credit</span>: Credit for future purchases on <span
                    class="font-bold">{{ config('app.name', 'Laravel') }}</span>.</li>
        </ul>

        <p>You must report defective or damaged items within <span class="underline">7 days</span> of delivery.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">4. How to Return an Item</h2>

        <p>To initiate a return, please follow these steps:</p>

        <ol class="list-decimal ml-6 space-y-2">
            <li>Contact our support team at <a wire:prenvent
                    class="text-purple-600 hover:underline">support@example.com</a> with your order number
                and reason for return.</li>
            <li>Package the item securely in its original packaging, including all accessories and proof of purchase.
            </li>
            <li>Ship the item to the return address provided by our support team, using a trackable shipping service.
            </li>
            <li>Once we receive and inspect the item, we will process your refund or replacement.</li>
        </ol>

        <p><span class="font-bold">Note</span>: You are responsible for return shipping costs unless the return is due
            to our error (e.g., defective or incorrect item).</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">5. Exchanges</h2>

        <p>If you wish to exchange an item (e.g., for a different size or color), please contact us to confirm
            availability. Exchanges are subject to the same eligibility criteria as returns. We will provide
            instructions for returning the original item and shipping the replacement.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">6. International Returns</h2>

        <p>For international orders, returns are accepted within <span class="underline">30 days</span> of delivery,
            subject to the same conditions. Customers are responsible for all return shipping costs, including customs
            fees and duties. Please contact us for specific instructions.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">7. Contact Information</h2>

        <p>If you have questions about our Return Policy or need assistance with a return, please reach out to us at:
        </p>

        <p><span class="font-bold">Email</span>: <a wire:prevent
                class="text-purple-600 hover:underline">support@example.com</a></p>
        <p><span class="font-bold">Mailing Address</span>: {{ config('app.name', 'Laravel') }} Support Team, 1234
            Commerce Lane, Suite 500, Business City, BC 56789</p>

        <p>We aim to respond to all inquiries within <span class="underline">30 days</span>.</p>

        <div class="alert bg-softPurple border-0 text-gray-500 mt-8">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                class="stroke-current shrink-0 w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>This Return Policy was last updated on {{ date('F j, Y') }}.</span>
        </div>
    </div>
</div>
