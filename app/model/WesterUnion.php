<?php

class WesterUnion{
	
	var $amount;
	var $shipping;	
	
	public function WesterUnion($amount, $shipping){
		$this->amount = $amount;
		$this->shipping = $shipping;
	}
	
	function generaFormulario(){	
		$this->form='
		<form name="checkout_confirmation" action="seccion/pedido/confirmado" method="post">	
			<input type="hidden" name="amount" value="'.$this->amount.'">
			<input type="hidden" name="shipping" value="'.$this->shipping.'">

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
		return $this->form;	
	//$pedido->procesaPedido();					
	header("Location: compra_realizada.php");
	}	
}

?>