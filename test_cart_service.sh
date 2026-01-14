#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}======================================${NC}"
echo -e "${BLUE}Testing Cart Service (Port 8009)${NC}"
echo -e "${BLUE}======================================${NC}\n"

# Test 1: Get empty cart
echo -e "${BLUE}Test 1: Get empty cart for user 5${NC}"
curl -s http://localhost:8009/cart/5
echo -e "\n"

# Test 2: Add item to cart
echo -e "${BLUE}Test 2: Add item to cart${NC}"
curl -s -X POST http://localhost:8009/cart/items \
  -H "Content-Type: application/json" \
  -d '{"user_id": 5, "book_id": 1, "quantity": 2, "price": 29.99}'
echo -e "\n"

# Test 3: Add another item
echo -e "${BLUE}Test 3: Add another item to cart${NC}"
curl -s -X POST http://localhost:8009/cart/items \
  -H "Content-Type: application/json" \
  -d '{"user_id": 5, "book_id": 2, "quantity": 1, "price": 39.99}'
echo -e "\n"

# Test 4: Get cart with items
echo -e "${BLUE}Test 4: Get cart with items${NC}"
curl -s http://localhost:8009/cart/5
echo -e "\n"

# Test 5: Update item quantity
echo -e "${BLUE}Test 5: Update item quantity${NC}"
curl -s -X PUT http://localhost:8009/cart/items/2 \
  -H "Content-Type: application/json" \
  -d '{"quantity": 3}'
echo -e "\n"

# Test 6: Get updated cart
echo -e "${BLUE}Test 6: Get updated cart${NC}"
curl -s http://localhost:8009/cart/5
echo -e "\n"

# Test 7: Checkout
echo -e "${BLUE}Test 7: Process checkout${NC}"
curl -s -X POST http://localhost:8009/cart/5/checkout
echo -e "\n"

# Test 8: Remove item
echo -e "${BLUE}Test 8: Remove item from cart${NC}"
curl -s -X DELETE http://localhost:8009/cart/items/2
echo -e "\n"

# Test 9: Get cart after removal
echo -e "${BLUE}Test 9: Get cart after removal${NC}"
curl -s http://localhost:8009/cart/5
echo -e "\n"

# Test 10: Clear cart
echo -e "${BLUE}Test 10: Clear entire cart${NC}"
curl -s -X DELETE http://localhost:8009/cart/5/clear
echo -e "\n"

# Test 11: Verify cart is empty
echo -e "${BLUE}Test 11: Verify cart is empty${NC}"
curl -s http://localhost:8009/cart/5
echo -e "\n"

echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}All tests completed!${NC}"
echo -e "${GREEN}======================================${NC}"
