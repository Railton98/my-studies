/**
 * Goal data model
 * Represents a single goal in the DoIt application
 */
export interface Goal {
  id: string;
  title: string;
  endDate: string; // ISO date string (YYYY-MM-DD)
  status: "current" | "completed";
  createdAt: string; // ISO timestamp
}

/**
 * Application state for goals management
 */
export interface GoalsState {
  goals: Goal[];
  isLoading: boolean;
  error: string | null;
}
