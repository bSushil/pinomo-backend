<?php
namespace Core\Policy;

use Core\Contracts\Policy\Policy;
use Illuminate\Support\Facades\Auth;

class AbstractPolicy implements Policy
{
    protected $_user;
    
    public function __construct()
    {
        $this->_user = Auth::user();
    }
}