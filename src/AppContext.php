<?php

namespace evelikto\di;
use evelikto\di\{storage, creator, reader, resolver};

/** Default container configuration with all features enabled */
class AppContext extends AppContextBase
{
    use
          storage\LocalStorage
        , storage\SessionStorage
        , storage\GlobalStorage
        , creator\MethodCreator
        , creator\ClassCreator
        , creator\InterfaceAliasCreator
        , creator\InterfaceMethodCreator
        , reader\ConstReader
        , resolver\NameResolver
        , resolver\TypeResolver
        , resolver\DefaultResolver
    ;
}