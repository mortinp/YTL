<!-- RIBBON -->
<style>
.ribbon {
  position: fixed;
  right: -5px; top: -5px;
  z-index: 99999999999999;
  /*overflow: hidden;*/
  width: 75px; height: 75px;
  text-align: right;
}
.ribbon span {
  font-size: 15px;
  font-weight: bold;
  color: #FFF;
  /*text-transform: uppercase;*/
  text-align: center;
  line-height: 20px;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
  width: 300px;
  display: block;
  background: #79A70A;
  background: linear-gradient(#9BC90D 0%, #79A70A 100%);
  box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
  position: absolute;
  top: 27px; right: -72px;
  padding-left: 75px;
  padding-right: 75px;
  padding-top: 10px;
  padding-bottom: 10px;
}
.ribbon span::before {
  content: "";
  position: absolute; left: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid #79A70A;
  border-right: 3px solid transparent;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
.ribbon span::after {
  content: "";
  position: absolute; right: 0px; top: 100%;
  z-index: -1;
  border-left: 3px solid transparent;
  border-right: 3px solid #79A70A;
  border-bottom: 3px solid transparent;
  border-top: 3px solid #79A70A;
}
</style> 
<div class="ribbon"><span><?php echo __('Cuba está<br><b style="color: orangered">CERRADA a turismo</b> debido a COVID-19<br>Cuídate!')?></span></div>