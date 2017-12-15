<?php

class BookingAdditionalService extends DB
{

    /**
     * BookingAdditionalService constructor.
     * @param string $charset
     */
    public function __construct($charset = 'UTF8')
    {
        try {
            parent::__construct($charset);
            $this->setTable('booking_additionals_services');
            $this->setFields(['id', 'booking_id','additional_service_id']);
        } catch (DBException $e) {
        } catch (VarNoInitializedException $e) {
        }
    }
}