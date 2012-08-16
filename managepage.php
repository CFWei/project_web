<?php
	$content='<div class="ItemBlock">
				<div class="ControlBlock">
					<button class="ControlButton">下一號</button>	
					<button class="ControlButton">跳過</button>
					<button class="ControlButton">使用者</button>
					<button class="ControlButton">輸入號碼</button>
				</div>
				<div class="InformationBlock">	
					<div class="ItemTop">
						<div class="ItemName">
							商品名稱
						</div>
						<div class="NowValue">
							999
						</div>
					</div>
					<div class="ItemButtom">
						<div class="WaitNum">
							<span class="WaitNumText">
								等候人數：
							</span>
							<span class="WaiNumValue">
								100
							</span>
						</div>
						<div class="TakenNum">
							<span class="TakenNumText">
								已抽號碼：
							</span>
							<span class="TakenNumValue">
								100
							</span>
						</div>

					</div>
				</div>
			</div>';


?>


<div class="ItemTable">
	<div class="ItemTr">
		<div class="ItemTd">
			<?php echo $content?>
		</div>
		<div class="ItemTd">
			<?php echo $content?>
		</div>		
	</div>
	<div class="ItemTr">
		<div class="ItemTd">
			<?php echo $content?>
		</div>
		<div class="ItemTd">
			<?php echo $content?>
		</div>		
	</div>
</div>

	
