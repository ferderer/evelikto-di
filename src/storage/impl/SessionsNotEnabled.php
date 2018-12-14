<?php

namespace evelikto\di\storage\impl;

/** Is thrown when sessions are active, but session scope is used. */
class SessionsNotEnabled extends \evelikto\di\DiException {}