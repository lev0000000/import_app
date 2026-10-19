import { Component, output, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { ProductFilters } from '../../models/products-filters';

@Component({
  selector: 'app-products-filter',
  imports: [FormsModule],
  templateUrl: './products-filter.html',
  styleUrl: './products-filter.css'
})
export class ProductsFilter {
  name = signal('');
  minPrice = signal<number | null>(null);
  maxPrice = signal<number | null>(null);

  filtersChanged = output<ProductFilters>();

  applyFilters() {
    this.filtersChanged.emit({
      name: this.name().trim(),
      minPrice: this.minPrice(),
      maxPrice: this.maxPrice()
    });
  }

  resetFilters() {
    this.name.set('');
    this.minPrice.set(null);
    this.maxPrice.set(null);
    this.applyFilters();
  }
}