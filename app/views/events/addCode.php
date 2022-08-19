<?php require APPROOT . '/views/inc/header.php'; ?>
<a href="<?php echo URLROOT ?>/events_dashboard/<?php echo $data["event_id"] ?>/discount_code" class="btn btn-light"><i class="fa-solid fa-angle-left"></i> Back</a>
<div class="container w-50 mb-5">
    <div class="card card-body bg-light mt-5">
        <h5>Create New Discount Code</h5>
        <!-- 
        $data = [
            'code' => '',
            'event_id' => $event_id,
            'start_date' => '',
            'end_date' => '',
            'type' => '',
            'type_value' => '',
            'customer_eligibility' => '',
            'limit_times' => '',
            'limit_times_value' => '',
            'limit_one' => '',
        ];   
     -->
        <form action="<?php echo URLROOT ?>/events_dashboard/<?php echo $data["event_id"] ?>/discount_code/add" method="post">

            <!-- 1. Code itself, empty, required, has error msg-->
            <div class="form-group mb-3 mt-3">
                <label for="code">Discount Code</label>
                <input type="text" name="code" class="form-control form-control-sm <?php echo (!empty($data['code_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['code']; ?>">
                <span class="invalid-feedback"><?php echo $data['code_err']; ?></span>
            </div>

            <!-- 2. Value: contains 2 radio(percentage/amount) and 1 text input(value), with default-percentage, empty input for value, has error msg-->
            <div class="form-group mb-4">
                <label for="type" class="me-4">Value</label>
                <br>

                <!-- type: percentage or amount -->
                <input type="radio" checked name="type" class="<?php echo (!empty($data['type_err'])) ? 'is-invalid' : ''; ?>" value='percentage' />
                <label class="me-2">Percentage</label>

                <input type="radio" <?php if ($data['type'] == 'amount') echo "checked" ?> name="type" class="<?php echo (!empty($data['amount_err'])) ? 'is-invalid' : ''; ?>" value="amount" />
                <label>Amount</label>
                <br>


                <!-- value of percentage/fixed amount -->
                <input type="number" name="type_value" class="form-control form-control-sm <?php echo (!empty($data['type_value_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['type_value']; ?>">

                <!-- if no value, will show error -->
                <span class="invalid-feedback"><?php echo $data['type_value_err']; ?></span>
            </div>

            <!-- 3. Customer eligibility with default-all, no error msg-->
            <div class="form-group mb-4">
                <label for="type" class="me-4">Customer eligibility</label>
                <br>

                <!-- all customers -->
                <input id="all-customer" type="radio" checked name="customer_eligibility" class="<?php echo (!empty($data['customer_eligibility_err'])) ? 'is-invalid' : ''; ?>" value='all' />
                <label class="me-2">All customers</label>
                <br>

                <!-- specific groups -->
                <input type="radio" <?php if ($data['customer_eligibility'] == 'group') echo "checked" ?> name="customer_eligibility" class="specific <?php echo (!empty($data['customer_eligibility_err'])) ? 'is-invalid' : ''; ?>" value='group' />
                <label class="me-2">Specific customer segments</label>
                <br>

                <!-- specific customers -->
                <input type="radio" <?php if ($data['customer_eligibility'] == 'specific') echo "checked" ?> name="customer_eligibility" class="specific <?php echo (!empty($data['customer_eligibility_err'])) ? 'is-invalid' : ''; ?>" value='specific' />
                <label class="me-2">Specific customers</label>

                <!-- To search -->
                <div id="customer-search" class="input-group hide">
                    <input class="form-control" type="search" placeholder="Search for customers. To be done" aria-label="Search">
                    <button class="btn magnifying-glass" type="submit">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </div>

                <!-- customers error -->
                <span class="invalid-feedback"><?php echo $data['customer_eligibility_err']; ?></span>

            </div>

            <!-- 4. Maximum discount uses, can be empty, has error msg -->
            <div class="form-group mb-4">
                <label for="Max_uses" class="me-4">Maximum discount uses</label>
                <br>

                <!-- Limit number of times this discount can be used: limit_times 1/0 -->
                <input type="checkbox" <?php if ($data['limit_times'] == '1') echo "checked" ?> name="limit_times" class="<?php echo (!empty($data['limit_times_err'])) ? 'is-invalid' : ''; ?>" value='1' />
                <label class="me-2">Limit number of times this discount can be used
                </label>

                <!-- how many times it can be used: limit_times_value-->
                <input type="number" name="limit_times_value" class="form-control form-control-sm w-25 <?php echo (!empty($data['limit_times_value_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['limit_times_value']; ?>">

                <!-- if limit times is checked but no value for the time, this will show error -->
                <span class="invalid-feedback"><?php echo $data['limit_times_value_err']; ?></span>

                <!-- Limit to one use per customer: limit_one 1/0 -->
                <input type="checkbox" <?php if ($data['limit_one'] == '1') echo "checked" ?> name="limit_one" class="<?php echo (!empty($data['limit_one_err'])) ? 'is-invalid' : ''; ?>" value="1" />
                <label>Limit to one use per customer</label>
                <br>
            </div>

            <!-- 5. Active dates, err msg if empty start_date-->
            <div class="form-group mb-4">
                <label for="date" class="me-4">Active dates</label><br>
                <!-- start date -->
                <label for="start_date" class="me-4" style="font-size:14px">Start Date</label>
                <input class="form-control" type="datetime-local" name="start_date" placeholder="Select Date and Time"></input>

                <!-- if start date is empty, show error -->
                <span class="invalid-feedback"><?php echo $data['date_err']; ?></span>

                <!-- end date -->
                <input type="checkbox" id="end-date-checkbox" <?php if ($data['end_date']) echo "checked" ?> />
                <label class="me-2" style="font-size:14px">End Date</label>

                <input class="form-control <?php if (!$data['end_date']) echo "hide" ?>" id="end-date-input" type="datetime-local" name="end_date" placeholder="Select Date and Time"></input>

            </div>
            <input type="submit" value="Submit" class="btn btn-outline-primary mt-3">
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>