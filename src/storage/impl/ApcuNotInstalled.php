<?php

namespace evelikto\di\storage\impl;

/** Is thrown when the APCu extension is not installed, but global scope is used. */
class ApcuNotInstalled extends \evelikto\di\DiException {}