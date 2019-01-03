<?php
class Transferencia{

	private $_form;
	private $_urlProcess;
	private $_nCcuenta;
	private $_banco;	
	private $_amount;
	private $_shipping;
	
	public function __construct( $amount, $shipping ){
		$this->_amount = $amount;
		$this->_shipping = $shipping;
	}
	
	public function generaFormulario(){	

            $this->_form='
            <form name="checkout_confirmation" action="seccion/pedido/confirmado" method="post">	
                <input type="hidden" name="amount" value="'.$this->_amount.'">
                <input type="hidden" name="shipping" value="'.$this->_shipping.'">
                <div class="row">
	                <div class="col-6 text-right">
	                	<button type="button" onclick="" id="btn_volver" class="btn btn-outline-secondary remove-tablet">
	                		<i class="icon-arrow-left"></i><span class="">&nbsp;Regresar</span>
	                	</button>
	                </div>
	              	<div class="col-md-6 text-continuar">
	              		<button type="submit" class="btn btn-verde-donregalo" name="" id="btn_confirmar"><span class="">Continuar&nbsp;</span><i class="icon-arrow-right"></i></button>
	              	</div>
              	</div>
            </form>';
            return $this->_form;	
            header("Location: compra_realizada.php");
	}	
}
?>