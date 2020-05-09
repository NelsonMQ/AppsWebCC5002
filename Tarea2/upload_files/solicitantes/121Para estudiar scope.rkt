#lang racket
;; NOTES - esto no es racket valido

;; 1. con substitución

{with {x 3}
  {with {y 4}
    {with {z 5}
       {+ x {+ y z}}}}}

-->subst x 3

  {with {y 4}
    {with {z 5}
       {+ 3 {+ y z}}}}

-->subst y 4

    {with {z 5}
       {+ 3 {+ 4 z}}}

-->subst z 5

       {+ 3 {+ 4 5}}

--> calc...

;; 2. con environments (ambientes)

{with {x {+ 1 2}}
  {with {y 4}
    {with {z 5}
       {+ x {+ y z}}}}}   []   ; ambiente vacío

--> extend env con x

  {with {y 4}
    {with {z 5}
       {+ x {+ y z}}}}}   [x->3] ; ambiente extendido

--> extend env con y

   {with {z 5}
       {+ x {+ y z}}}     [y->4, x->3]

--> extend env con z

       {+ x {+ y z}}      [z->5, y->4, x->3]

-->* lookup de x y z en env

       {+ 3 {+ 4 5}}
 


; dynamic scope as a feature

;; with static scope
;main
{with {user-level {read-line ...}}   ; we know user-level
  {f 1 user-level}}

{define {f x l} ; need to modify signature
  ...
  ... {h 2 l} ... ; and pass level everywhere
  ...}


{define {h x l}
  ...
  ... {g 10 l} ...
  ...}


{define {g x l}
  {if {> l 2}  ; we use user-level
      {a 1}
      {b 1}}}



;;; with dynamic scope

;main
{with {user-level {read-line ...}}   ; we know user-level
  {f 1 user-level}}

{define {f x} 
  ...
  ... {h 2} ...
  ...}


{define {h x}
  ...
  ... {g 10} ...
  ...}


{define {g x l}
  {if {> user-level 2}  ; we use user-level
      {a 1}
      {b 1}}}










