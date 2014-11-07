<?php
namespace YAFF\Base\Utility;

use Symfony\Component\HttpFoundation\Request;

/**
 * CSRFProtectionService is a Service to provide simple
 * generation and validation of tokens for CSRF Protection
 *
 * @author Alex
 */
class CSRFProtectionService
{
    private $app;

    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Saves a generated token into session and returns the generated token for csrf protection
     * The form must have a hidden input field where the token can be used
     * This hidden input field will be validated against the saved token (funtion: validateCSRFToken)
     * @return string
     */
    public function getCSRFTokenForForm() {
        $token = $this->generateToken(20);
        $this->app['session']->set('_csrf_token', $token);

        return $token;
    }

    /**
     * Validates the submitted csrf token against the token saved in the session
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param boolean $invalidateToken token is only valid for one submit
     * @param string $fieldName Set the name of the hidden input field default='_csrf_token'
     * @return boolean
     */
    public function validateCSRFToken(Request $request, $invalidateToken = false, $fieldName = '_csrf_token') {
        $savedToken = $this->app['session']->get('_csrf_token');
        $submittedToken = $request->get($fieldName);
        $result = ($savedToken == $submittedToken);

        // generate and save new token
        // token is only valid for one submit
        if ($invalidateToken) {
            $this->getCSRFTokenForForm();
        }
        return $result;
    }

    /**
     * Returns a token
     * @param int $length
     * @param boolean $alphaNumeric
     * @return string
     */
    private function generateToken($length, $alphaNumeric = true) {
        $numeric = '0123456789';
        $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';

        if ($alphaNumeric) {
            $chars = $numeric . $alpha;
        } else {
            $chars = $alpha;
        }

        for ($i = 0; $i < $length; $i++) {
            $tmpStr = str_shuffle($chars);
            $token .= $tmpStr[0];
        }
        return $token;
    }
}
