

                        <div class="card-title mb-3">Agreed Amount</div>

                        <input type="hidden" name="company_now" value="1">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-5" style="margin-bottom:05px;">
                                        <label for="visit_entry_date">Discount Name</label>
                                        <select name="discount_name[]" class="form-control" >
                                            <option value="" selected disabled >please select option</option>
                                            @foreach($discount_names as $names)
                                                <option value="{{ $names->names }}">{{ $names->names }}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5" style="margin-bottom:05px;">
                                        <label for="visit_entry_date">Discount Amount</label>
                                        <input type="number" name="discount_amount[]" id="discount_offer"  class="form-control amount_cls" >
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-icon m-1 " id="btn_add_discount_row" type="button" style="position: absolute; top: 20px;"><span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                    </div>
                                </div>

                                <div class="row append_discount_row"> </div>
                            </div>

                            <div class="col-md-6">

                                <div class="row ">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Agreed Amount</label>
                                        <input type="number" required class="form-control amount_cls" required name="agreed_amount"   id="agreed_amount">
                                    </div>

                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Advance Amount</label>
                                        <input type="number" required class="form-control amount_cls" required name="advance_amount"   id="advance_amount">
                                    </div>

                                </div>

                            </div>
                        </div>

                     <div class="row">

                            <div class="col-md-6">

                            </div>

                         <div class="col-md-6">
                             <div class="row">
                                 <div class="col-md-6">
                                     <label for="repair_category">Final Due Amount</label>
                                     <input type="number" required class="form-control"  name="final_amount"   readonly id="final_amount">
                                 </div>

                                 <div class="col-md-6">
                                     <label for="repair_category">Select Agreement</label>
                                     <input type="file"  name="attchemnt" class="form-control" >
                                 </div>

                                 <div class="col-md-6">
                                         <label class="checkbox checkbox-outline-primary mt-2" >
                                             <input type="checkbox" value="1" name="payroll_deduct" id="payroll_deduct"><span>Is Payroll Deduct.?</span><span class="checkmark"></span>
                                         </label>

                                     <label>
                                         <span>Amount</span>
                                     </label>
                                     <h6 id="final_amount_label_cls">0</h6>
                                 </div>
                                 <div class="col-md-6 payroll_deduct_amount_div hide_cls" >
                                     <label for="repair_category">Payroll Deduct Amount</label>
                                     <input type="number"    class="form-control step_amount_cls"  name="payroll_deduct_amount"    id="payroll_deduct_amount">
                                 </div>

                             </div>




                             <div class="row step_amount_row" >
                                 <div class="col-md-6 form-group "  >
                                 <label for="visa_requirement">Select step Amount </label>
                                 <select name="select_amount_step[]" id="select_amount_step"   class="form-control form-control-rounded select_amount_step_cls">
                                     <option value=""  >Select option</option>
                                     @foreach($master_steps as $steps)
                                         @if($steps->id=="11" || $steps->id=="12" || $steps->id=="13" || $steps->id=="14" )
                                             <option value="{{ $steps->id }}"  class="medical_cls_option" >{{ $steps->step_name }}</option>
                                         @elseif($steps->id=="6" || $steps->id=="7")
                                             <option value="{{ $steps->id }}"  class="evisa_cls_option" >{{ $steps->step_name }}</option>
                                         @else
                                             <option value="{{ $steps->id }}"  >{{ $steps->step_name }}</option>
                                         @endif

                                     @endforeach
                                 </select>
                                 </div>

                                 <div class="col-md-6 form-group "  >
                                     <label for="visa_requirement">Amount</label>
                                     <input type="number" name="step_amount[]"  id="step_amount_first"  class="form-control step_amount_cls ">
                                     <button class="btn  m-1 btn-primary pull-right  add_btn_form add_step_form_btn btn-icon "  style="margin-bottom:10px;">
                                         <span class="ul-btn__icon"><i class="i-Add"></i></span></button>
                                 </div>


                             </div>

                             <div class="row  step_amount_row amount_step_row_cls"></div>

                         </div>

                    </div>
