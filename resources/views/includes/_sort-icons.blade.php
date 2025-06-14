<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@if ($sortField !== $field)
    <i class="text-gray-500 fas fa-sort"></i>
@elseif ($sortAscending)
    <i class="text-gray-200 fas fa-sort-up"></i>
@else
    <i class="text-gray-200 fas fa-sort-down"></i>
@endif

