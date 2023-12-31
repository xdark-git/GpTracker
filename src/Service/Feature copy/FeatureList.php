<?php

namespace App\Services\Feature;

class FeatureList
{
    public const ENTREPRISE_LOCATOR             = "entreprise-locator";
    public const ENTREPRISE                     = "entreprise";
    public const ACCOUNT                        = 'account';
    public const AUTHENTICATION                 = 'auth';
    public const API                            = 'api';
    public const DOCUMENT_CONVERSION            = "document-conversion";
    public const DASHBOARD                      = "dashboard";
    public const INVOICE                        = 'invoice';
    public const PRODUCTION                     = 'production';
    public const ESTIMATE                       = 'estimate';
    public const DELIVERY_NOTE                  = 'delivery-note';
    public const DELIVERY_RECEIPT               = 'delivery-receipt';
    public const SUPPLIER_INVOICE               = 'supplier-invoice';
    public const PURCHASE_ORDER                 = 'purchase-order';
    public const PURCHASE_ORDER_CUSTOMER        = 'purchase-order-customer';
    public const PRODUCT                        = 'product';
    public const PRODUCT_SPECIAL_PRICE          = 'product-special-price';
    public const PRODUCT_COMPONENT              = 'product-component';
    public const PROJECT                        = 'project';
    public const BROKEN                         = 'broken';
    public const PROJECT_MEMBERS                = 'project.members';
    public const SUPPLIER                       = 'supplier';
    public const INVOICE_PAYMENT_RECORD         = 'invoice-payment-record';
    public const DOCUMENT_MODELS                = 'document-models';
    public const CUSTOMER_PURCHASE_ORDER        = 'customer-purchase-order';
    public const TRIGGERS                       = 'triggers';
    public const CUSTOM_REPORTS                 = 'custom-reports';
    public const DEFAULT_REPORTS                = 'default-reports';
    public const CUSTOM_REPORTS_VALIDATION      = 'custom-reports-validation';
    public const CUSTOM_REPORTS_EXECUTION       = 'custom-reports-execution';
    public const FINANCE_ACCOUNTS               = 'finance-accounts';
    public const EXPENSE_CATEGORIES             = 'expense-categories';
    public const LEADS                          = 'leads';
    public const CUSTOM_FIELDS                  = 'custom-fields';
    public const CUSTOM_MODULES                 = 'custom-modules';
    public const CONTRACTS                      = 'contracts';
    public const CLIENT_CONTACT                 = 'client-contact';
    public const SUPPLIER_INVOICES              = 'supplier-invoices';
    public const SUPPLIER_PURCHASE_ORDERS       = 'supplier-purchase-orders';
    public const CLIENT_ATTACHMENTS             = 'client-attachments';
    public const EXPENSE_ATTACHMENTS            = 'expense-attachments';
    public const CHEQUE_ATTACHMENTS             = 'cheque-attachments';
    public const SUPPLIER_ATTACHMENTS           = 'supplier-attachments';
    public const AVOIRS                         = 'avoirs';
    public const AVOIR_SUPPLIER                 = 'avoir-supplier';
    public const EXPENSE                        = 'expenses';
    public const CLIENT_ADVANCE                 = 'client-advance';
    public const REMINDERS                      = 'reminders';
    public const STAFF_TASKS                    = 'staff-tasks';
    public const USER_ADMIN_NOTE                = 'user-admin-note';
    public const LEADS_NOTE                     = 'leads-note';
    public const CLIENT_ACTIVITY_LOG            = 'client-activity-log';
    public const INVOICE_ACTIVITY_LOG           = 'invoice-activity-log';
    public const SUPPLIER_INVOICE_ACTIVITY_LOG  = 'supplier-invoice-activity-log';
    public const DELIVERY_RECEIPT_ACTIVITY_LOG  = 'delivery-receipt-activity-log';
    public const AVOIR_SUPPLIER_ACTIVITY_LOG    = 'avoir-supplier-activity-log';
    public const SUPPLIER_ORDER_ACTIVITY_LOG    = 'supplier-order-activity-log';
    public const STOCK_TRANSFER_ACTIVITY_LOG    = 'stock-transfer-activity-log';
    public const DELIVERY_NOTE_PAYMENT          = 'delivery-note-payment';
    public const CONTRACT_ATTACHMENTS           = 'contract-attachments';
    public const LEAD_ATTACHMENTS               = 'lead-attachments';
    public const PRODUCT_ATTACHMENTS            = 'product-attachments';
    public const TICKET_ATTACHMENTS             = 'ticket-attachments';
    public const SUPPLIER_INVOICE_ATTACHMENTS   = 'supplier-invoice-attachments';
    public const AVOIR_SUPPLIER_ATTACHMENTS     = 'supplier-avoir-attachments';
    public const STAFF_TASKS_ATTACHMENTS        = 'staff-tasks-attachments';
    public const CONTRACT_RENEWAL               = 'contract-renewal';
    public const PRODUCT_CONDITIONNING          = 'product.conditionning';
    public const PRODUCT_VARIANTS               = 'product.variants';
    public const LOGGING                        = 'logging';
    public const IMPORT_FILE                    = 'import-file';
    public const TEMPLATES                      = 'templates';
    public const CUSTOMER_ORDER_ATTACHMENTS     = 'customer-order-attachments';
    public const PURCHASE_ORDER_ATTACHMENTS     = 'purchase-order-attachments';
    public const PRODUCT_CATEGORIES             = 'product-categories';
    public const ADVANCED_FILTERS               = 'advanced-filters';
    public const CAISSE_FINANCE                 = 'caisse-finance';
    public const DELIVERY_RECEIPT_ATTACHMENTS   = 'delivery_receipt_attachments';

    // data import
    public const DATA_IMPORT                         = 'data-import';
    public const DATA_IMPORT_BANK_STATEMENT          = 'data-import.bank-statement';
    public const DATA_IMPORT_DELIVERY_NOTES          = 'data-import.delivery-note';
    public const DATA_IMPORT_DELIVERY_RECEIPTS       = 'data-import.delivery-receipt';
    public const DATA_IMPORT_PURCHASE_ORDERS         = 'data-import.purchase-order';
    public const DATA_IMPORT_PURCHASE_ORDER_CUSTOMER = 'data-import.purchase-order-customer';
    public const DATA_IMPORT_PRODUCTS                = 'data-import.products';
    public const DATA_IMPORT_ADVANCES                = 'data-import.advances';
    public const DATA_IMPORT_PRODUCT_SPECIAL_PRICE   = 'data-import.product.special-price';
    public const DATA_IMPORT_PRODUCT_BATCH           = 'data-import.product.batch';
    public const DATA_IMPORT_PROJECTS                = 'data-import.projects';
    public const DATA_IMPORT_INVOICES                = 'data-import.invoices';
    public const DATA_IMPORT_ESTIMATES               = 'data-import.estimates';
    public const DATA_IMPORT_SUPPLIERS               = 'data-import.suppliers';
    public const DATA_IMPORT_LEADS                   = 'data-import.leads';
    public const DATA_IMPORT_CLIENTS                 = 'data-import.clients';
    public const CACHE                               = 'cache';
    public const CLIENTS                             = 'clients';
    public const CHEQUES                             = 'cheques';
    public const DATA_IMPORT_CUSTOM_MODULE           = 'data-import.custom-module';
    public const SUPPLIER_INVOICE_PAYMENT_RECORD     = 'supplier-invoice-payment-record';
    public const DELIVERY_RECEIPT_PAYMENT            = 'delivery-receipt-payment';
    public const LEAD_ACTIVITY_LOG                   = 'lead-activity-log';
    public const CONTRACT_TAGS_VALUE                 = 'contract-tags-value';
    // data lookup
    public const DATA_LOOKUP            = 'data-lookup';
    public const STOCK_RECALCULATION    = 'stock.recalculation';
    public const STOCK                  = 'stock';
    public const STOCK_TRANSFER         = 'stock.transfer';
    public const LOCATION               = 'location';
    public const INVENTORY              = 'inventory';
    public const INVOICE_ATTACHMENT     = 'invoice-attachment';
    public const WEBHOOKS               = 'webhooks';
    public const SHOPIFY                = 'shopify';
    public const CURRENCY               = 'currency';
    public const OPTION                 = "option";
    public const ORDERS                               = 'orders';
    public const CASH_REGISTER                        = 'cash-register';
    public const HYDRATION                            = 'hydration';
    public const EXPORT                               = 'export';
    public const PRODUCT_OPTIONS                      = 'product.options';
    public const PRODUCT_PACK                         = 'product.pack';
    public const PRODUCT_BATCH                        = 'product.batch';
    public const CLIENTS_MERGE                        = 'clients.merge';
    public const SUPPLIERS_MERGE                      = 'suppliers.merge';
    public const ESTIMATE_KPI                         = 'estimate-kpi';
    public const KPI                                  = 'kpi';
    public const EVENT                                = 'event';
    public const PLATFORMS                            = 'platforms';
    public const POS                                  = 'pos';
    public const DRAFTED_CART                         = 'drafted-cart';
    public const AVOIR                                = 'avoir';
    public const STAFF_TASKS_COMMENTS                 = 'staff-tasks-comments';
    public const ACTIVITY_LOGS                        = 'activity-logs';
    public const FINANCE                              = 'finance';
    public const TREASURY                             = 'treasury';
    public const LOGIN                                = 'login';
    public const LOGIN_FAILED                         = 'login-failed';
    public const LOGIN_SUCCESS                        = 'login-success';
    public const PAYMENT                              = 'payment';
    public const CLIENT_ADVANCE_PAYMENT               = 'payment.client-advance';
    public const NOTIFICATION                         = 'notification';
    public const MISC                                 = 'misc';
    public const DOWNLOAD_ATTACHMENT                  = 'download-attachment';
    public const PRODUCT_MOVEMENT                     = 'product-movement';
    public const INTEGRATION                          = 'integration';
    public const PRESTASHOP                           = 'prestashop';
    public const SYNCHRONIZE_CURRENCIES_EXCHANGE_RATE = 'synchronize-currencies-exchange-rate';
    public const GLOBAL_SEARCH                        = 'global-search';
    public const RECURRING_EXPENSE                    = 'recurring-expense';
    public const NOMENCLATURE                         = 'nomenclature';
    public const PURCHASE_ORDER_CUSTOMER_PAYMENT      = 'purchase-order-customer-payment';
    public const OPTIONS                              = 'options';
    public const PERMISSIONS                          = 'permissions';
    public const FRONTEND_FORM                        = 'frontend-form';
    public const FRONTEND_TABLE                       = 'frontend-table';
}
